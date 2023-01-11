<?php
class Timeandtidebell_Vgm_Add_On_Ajax {

    public $errors = [];

    public function ttb_vgm_form_submit() {
        $nonce = $_POST['nonce'];

        if ( ! wp_verify_nonce( $nonce, 'ttb_vgm_form_nonce' ) ) {
            die( 'nonce not varify!' );
        }

        $upload = wp_handle_upload(
            $_FILES[ 'file' ],
            array( 'test_form' => false )
        );

        $post_id = $_POST['map_id'];

        $attachment = array(
            'guid'           => $upload[ 'url' ],
            'post_mime_type' => $upload[ 'type' ],
            'post_title'     => basename( $upload[ 'file' ] ),
            'post_content'   => '',
            'post_status'    => 'inherit',
        );

        add_image_size( 'custom-size', 300, 300, true );

        $filename   = $upload[ 'file' ];
        $attach_id  = wp_insert_attachment( $attachment, $filename, $post_id );

        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data["sizes"]["custom-size"]);
        set_post_thumbnail( $post_id, $attach_id );

        $store_img_url = wp_get_attachment_image_url($attach_id, 'custom-size');
    

        // sanitize user input
        $map_id                 = isset( $_POST['map_id'] ) ? intval( $_POST['map_id'] ) : 0;
        $date_id                = isset( $_POST['date_id'] ) ? intval( $_POST['date_id'] ) : 0;
        $type_id                = isset( $_POST['type_id'] ) ? intval( $_POST['type_id'] ) : 0;
        $season_id              = isset( $_POST['season_id'] ) ? intval( $_POST['season_id'] ) : 0;
        $wpgmza_ugm_add_address = isset( $_POST['wpgmza_ugm_add_address'] ) ? sanitize_text_field( $_POST['wpgmza_ugm_add_address'] ) : '';
        $ttb_marker_date        = isset( $_POST['ttb_marker_date'] ) ? sanitize_text_field( $_POST['ttb_marker_date'] ) : '';
        $ttb_marker_description = isset( $_POST['ttb_marker_description'] ) ? sanitize_text_field( $_POST['ttb_marker_description'] ) : '';

        if ( empty( $wpgmza_ugm_add_address ) ) {
            wp_send_json_error( [
                'status' => 'fail',
            ] );        
        }
        
        global $wpdb;

        $wpgmza_lat_lng = explode(", ", $wpgmza_ugm_add_address);

        //insert data
        $inserted = $wpdb->insert(
            "{$wpdb->prefix}wpgmza",
            [
                'map_id'      => $map_id,
                'address'     => $wpgmza_ugm_add_address,
                'lat'         => $wpgmza_lat_lng[0],
                'lng'         => $wpgmza_lat_lng[1],
                'description' => $ttb_marker_description,
                'approved'    => 0,
                'category'    => $type_id,
                'pic'         => $store_img_url,
            ],
            [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
            ]
        );

        // Insert Date
        $marker_id = $wpdb->insert_id;
        $wpdb->insert(
            "{$wpdb->prefix}wpgmza_markers_has_custom_fields",
            [
                'object_id' => $marker_id,
                'field_id'  => $date_id,
                'value'     => $ttb_marker_date,
            ],
            [
                '%d',
                '%d',
                '%s',
            ]
        );

        //Insert marker category
        $wpdb->insert(
            "{$wpdb->prefix}wpgmza_markers_has_categories",
            [
                'marker_id' => $marker_id,
                'category_id'  => $type_id,
            ],
            [
                '%d',
                '%d',
            ]
        );

        //Insert Season
        $marker_date = str_replace('-', ' ', $ttb_marker_date);
        $marker_month = explode(" ", $marker_date);
        $season = $this->getSeason($marker_month[1]);
        $wpdb->insert(
            "{$wpdb->prefix}wpgmza_markers_has_custom_fields",
            [
                'object_id' => $marker_id,
                'field_id'  => $season_id,
                'value'     => $season,
            ],
            [
                '%d',
                '%d',
                '%s',
            ]
        );

        //success message
        if ( $inserted ) {
            wp_send_json_success( [
                'status' => 'success',
            ], 200 );
        }

        return $wpdb->insert_id;
    }

    //create season
    public function getSeason($month){
        if (3 <= $month && $month <= 5) {
            return 'Spring';
          }
      
          if (6 <= $month && $month <= 8) {
            return 'Summer';
          }
      
          if (9 <= $month && $month <= 11) {
            return 'Autumn';
          }

        return 'Winter';
      
    }

    // Approve marker insert pic
    public function ttb_vgb_insert_pic() {
        global $wpdb;

        $marker_id  = isset( $_POST['marker_id'] ) ? intval( $_POST['marker_id'] ) : 0;
        $img_src    = isset( $_POST['img_src'] ) ? sanitize_text_field( $_POST['img_src'] ) : '';

        $marker_table= "{$wpdb->prefix}wpgmza";
        $wpdb->query($wpdb->prepare("UPDATE $marker_table SET pic='$img_src' WHERE id=$marker_id"));

    }

}
