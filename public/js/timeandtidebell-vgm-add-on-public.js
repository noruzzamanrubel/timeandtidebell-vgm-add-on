(function ($) {
  "use strict";

  // jQuery document ready
  $(document).ready(function () {
    
    let now = moment();
    let today = now.format("YYYY-MM-DD");
    $("#ttb_marker_date").attr("value", today);

    $("#ttb_marker_form").validate({
      rules: {
        ttb_marker_date: {
          required: true,
        },
        ttb_marker_address: {
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
        ttb_marker_address: {
          required: ttb_vgm_form.ttb_marker_address,
        },
        ttb_marker_type: {
          required: ttb_vgm_form.ttb_marker_type,
        },
        ttb_marker_description: {
          required: ttb_vgm_form.ttb_marker_description,
        },
      },
    });

    $("#ttb_marker_form_wrapper form").on("submit", function (e) {
      e.preventDefault();

      var ttb_marker_date = $(this).find('input[name="ttb_marker_date"]').val();
      var ttb_marker_address = $(this).find('input[name="ttb_marker_address"]').val();
      var ttb_marker_type = $(this).find(":selected").text();
      var ttb_marker_description = $(this).find('textarea[name="ttb_marker_description"]').val();

      $.ajax({
        url: ttb_vgm_form.ajaxurl,
        type: "POST",
        data: {
          action: ttb_vgm_form.action,
          data: {
            ttb_marker_date: ttb_marker_date,
            ttb_marker_address: ttb_marker_address,
            ttb_marker_type: ttb_marker_type,
            ttb_marker_description: ttb_marker_description,
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
