(function( $ ) {
	'use strict';

	  // jQuery document ready
	  $(document).ready(function () {
		$('body').on('click', '.wpgmza_approve_btn', function() {
			let img_link = $(this).parents('tr').find('img');
			let img_link_src = img_link[1].src;
			let marker_id = $(this).attr('id');

		   $.ajax({
			url: approve.ajaxurl,
			type: 'post',
			data: {
				action: 'ttb_vgb_insert_pic',
				img_src: img_link_src,
				marker_id: marker_id
			},
			success: function() {
				
			}
		});

		  });
	  });

})( jQuery );
