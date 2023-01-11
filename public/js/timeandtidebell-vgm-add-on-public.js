(function ($) {
  "use strict";

  // jQuery document ready
  $(document).ready(function () {

    //Get current date
    let now = moment();
    let today = now.format("YYYY-MM-DD");
    $("#ttb_marker_date").attr("value", today);

    // Form Validation
    $("#ttb_marker_form").validate({
      rules: {
        ttb_marker_date: {
          required: true,
        },
        ttb_marker_description: {
          maxlength: 100
        },
      },
      messages: {
        ttb_marker_date: {
          required: ttb_vgm_form.ttb_marker_date,
        },
        ttb_marker_description: {
          maxlength: ttb_vgm_form.maxlength
        },
      },
    });

    //Get map id
    var map_id = $("#wpgmza_ugm_map_id").val();

    //html dom ordering
    $("#ttb_marker_form_date_field").insertBefore(".wpgmza-address");
    $("#ttb_marker_address").insertBefore(".wpgmza-address");
    $("#ttb_marker_address_info").insertAfter(".wpgmza-address");
    $("#ttb_marker_type").insertBefore(".wpgmza-categories");

    //insert custom field id
    $('[data-custom-field-name="Date"]').parent().parent().attr( 'id', 'data_custom_field_date' );
    $('[data-custom-field-name="Types of entry"]').parent().parent().attr( 'id', 'data_custom_field_type' );
    $('[data-custom-field-name="Season"]').parent().parent().attr( 'id', 'data_custom_field_season' );

    var date_id = $('#data_custom_field_date').attr("data-custom-field-id");
    var season_id = $('#data_custom_field_season').attr("data-custom-field-id");

  //insert lat and lng into the form browser
    function displaylat_lon(lat, lon) {
      document.getElementById(`wpgmza_ugm_add_address_${map_id}`).value = lat + ", " + lon;
    }

    $(".wpgmza-address").append('<div id="ttb_map_icon"><img src="'+ttb_vgm_form.icon+'"></div>');

    //set lat lon from browser
    window.addEventListener("load", (event) => {
      event.preventDefault();
      navigator.geolocation.getCurrentPosition(function (position) {
        displaylat_lon(position.coords.latitude, position.coords.longitude);
      });
    });

    //add lat lon from browser
    $('body').on('click', '#ttb_map_icon', function() {
      navigator.geolocation.getCurrentPosition(function (position) {
        displaylat_lon(position.coords.latitude, position.coords.longitude);
      });
    });

    $('#wpgmza_category').on('change', function() {
      type_id = ( this.value );
    });

    //remove First option
    $("#wpgmza_category option:first").remove();
    $("#wpgmza_filter_select option:first").text('Types of entry');

    var type_id = $( "#wpgmza_category option:selected" ).val();
    $( ".wpgmaps_user_form" ).prev().css( "display", "none" );

    // Submit marker by ajax
    $("#ttb_marker_form_wrapper form").on("submit", function (e) {
      e.preventDefault();

      var wpgmza_ugm_add_address = $('.wpgmaps_user_form table').find('input[name="wpgmza_ugm_add_address"]').val();
      var ttb_marker_date = $('.wpgmaps_user_form table').find('input[name="ttb_marker_date"]').val();
      var ttb_marker_description = $(this).find('textarea[name="ttb_marker_description"]').val();

      var fd = new FormData();
      var file = jQuery(document).find('#ttb_file');

      var individual_file = file[0].files[0];

      if(individual_file){
        var  fileType = individual_file['type'];
        var validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {
            alert('This file type not allowed.');
            return false;
        }
      }

      $('.ttb_marker_form').append('<div class="ttb_loader"><span class="loader"></span></div>');
      fd.append("file", individual_file);
      fd.append('action', 'ttb_vgm_form_submit');
      fd.append('nonce', ttb_vgm_form.nonce);

        fd.append('wpgmza_ugm_add_address', wpgmza_ugm_add_address);
      fd.append('ttb_marker_date', ttb_marker_date);
      fd.append('ttb_marker_description', ttb_marker_description);
      fd.append('map_id', map_id);
      fd.append('date_id', date_id);
      fd.append('type_id', type_id);
      fd.append('season_id', season_id);

      $.ajax({
        type: 'POST',
        url: ttb_vgm_form.ajaxurl,
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.data.status === 'success') {
            $("#result_message").html("<div>" + $('#ttb_marker_form_wrapper').data('success-message') + "</div>");
            $("#ttb_marker_form_wrapper form").trigger("reset");
            $('#wpgmza_category').prop('selectedIndex',0);
            $('.ttb_loader').remove();
            if($( "#result_message" ).has( "div" )){
              $('#ttb_marker_submit').click(function(){
                  $("#result_message").empty();
              })
            };
          }else {
            $("#result_message").html("<div>"+ $('#ttb_marker_form_wrapper').data('error-message') +"</div>");
            $('.ttb_loader').remove();
          }
        },
      });
    });

  });
})(jQuery);
