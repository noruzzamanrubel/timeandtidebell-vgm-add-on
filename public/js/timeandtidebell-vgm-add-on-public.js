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
        ttb_marker_type: {
          required: true,
        },
        ttb_marker_description: {
          required: true,
        },
      },
      messages: {
        ttb_marker_date: {
          required: ttb_vgm_form.ttb_marker_date,
        },
        ttb_marker_type: {
          required: ttb_vgm_form.ttb_marker_type,
        },
        ttb_marker_description: {
          required: ttb_vgm_form.ttb_marker_description,
        },
      },
    });

    //Get map id
    var map_id = $("#wpgmza_ugm_map_id").val();

    //html dom ordering
    $("#ttb_marker_form_date_field").insertBefore(".wpgmza-address");

    //insert custom field id
    $('[data-custom-field-name="Date"]').parent().parent().attr( 'id', 'data_custom_field_date' );
    $('[data-custom-field-name="Types of entry"]').parent().parent().attr( 'id', 'data_custom_field_type' );
    $('[data-custom-field-name="Season"]').parent().parent().attr( 'id', 'data_custom_field_season' );

    var date_id = $('#data_custom_field_date').attr("data-custom-field-id");
    var type_id = $('#data_custom_field_type').attr("data-custom-field-id");
    var season_id = $('#data_custom_field_season').attr("data-custom-field-id");

  //insert lat and lng into the form browser
    function displaylat_lon(lat, lon) {
      document.getElementById(`wpgmza_ugm_add_address_${map_id}`).value = lat + ", " + lon;
    }
    
    window.addEventListener("load", (event) => {
      event.preventDefault();
      navigator.geolocation.getCurrentPosition(function (position) {
        displaylat_lon(position.coords.latitude, position.coords.longitude);
      });
    });  

    // Submit date by ajax
    $("#ttb_marker_form_wrapper form").on("submit", function (e) {
      e.preventDefault();
      var wpgmza_ugm_add_address = $('.wpgmaps_user_form table').find('input[name="wpgmza_ugm_add_address"]').val();
      var ttb_marker_date = $('.wpgmaps_user_form table').find('input[name="ttb_marker_date"]').val();
      var ttb_marker_type = $('#ttb_marker_type').find(":selected").text();
      var ttb_marker_description = $(this).find('textarea[name="ttb_marker_description"]').val();

      $.ajax({
        url: ttb_vgm_form.ajaxurl,
        type: "POST",
        data: {
          action: ttb_vgm_form.action,
          data: {
            ttb_marker_date: ttb_marker_date,
            wpgmza_ugm_add_address: wpgmza_ugm_add_address,
            ttb_marker_type: ttb_marker_type,
            ttb_marker_description: ttb_marker_description,
            map_id: map_id,
            date_id: date_id,
            type_id: type_id,
            season_id: season_id,
          },
          nonce: ttb_vgm_form.nonce,
        },
        success: function (data) {
          if (data.success === true) {
            $("#result_message").html("<div>" + data.data.message + "</div>");
            $("#ttb_marker_form_wrapper form").trigger("reset");
          } else if (data.success === false) {
            $("#result_message").html("<div>" + data.data.message + "</div>");
          }
        },
      });
    });
  });
})(jQuery);
