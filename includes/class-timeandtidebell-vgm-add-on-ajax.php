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
        $ttb_marker_type        = isset( $_POST['ttb_marker_type'] ) ? sanitize_text_field( $_POST['ttb_marker_type'] ) : '';
        $ttb_marker_description = isset( $_POST['ttb_marker_description'] ) ? sanitize_text_field( $_POST['ttb_marker_description'] ) : '';

        if ( empty( $ttb_marker_date ) || empty( $wpgmza_ugm_add_address ) || empty( $ttb_marker_type ) ) {
            $this->errors['wpgmza_ugm_add_address']   = __( 'Address is required adsfa', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_date']          = __( 'Date is required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_type']          = __( 'Type required', 'timeandtidebell-vgm-add-on' );
        }

        if ( ! empty( $this->errors ) ) {
            wp_send_json_error( [
                'message' => __( 'your submission did not received. Please fillup all field and resubmit again.', 'timeandtidebell-vgm-add-on' ),

            ] );        
        }


        global $wpdb;

        $wpgmza_lat_lng = explode(", ", $wpgmza_ugm_add_address);


        
        //Custom Marker icon Url
        $meta = get_option( 'ttb_location_icon' );
        $custom_icon_url        = "";
        if($meta !== ""){
            $flora_icon_url         = $meta['flora_icon'];
            $invertebrates_icon_url = $meta['invertebrates_icon'];
            $crustaceans_icon_url   = $meta['crustaceans_icon'];
            $fish_icon_url          = $meta['fish_icon'];
            $mammals_icon_url       = $meta['mammals_icon'];
            $seashells_icon_url     = $meta['seashells_icon'];
        }

        if($ttb_marker_type == "Flora"){
            $custom_icon_url = $flora_icon_url;
        }elseif($ttb_marker_type == "Invertebrates"){
            $custom_icon_url = $invertebrates_icon_url;
        }elseif($ttb_marker_type == "Crustaceans"){
            $custom_icon_url = $crustaceans_icon_url;
        }elseif($ttb_marker_type == "Fish"){
            $custom_icon_url = $fish_icon_url;
        }elseif($ttb_marker_type == "Mammals"){
            $custom_icon_url = $mammals_icon_url;
        }elseif($ttb_marker_type == "Seashells"){
            $custom_icon_url = $seashells_icon_url;
        }

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
                'icon'        => $custom_icon_url,
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

        //Insert Type of entry
        $wpdb->insert(
            "{$wpdb->prefix}wpgmza_markers_has_custom_fields",
            [
                'object_id' => $marker_id,
                'field_id'  => $type_id,
                'value'     => $ttb_marker_type,
            ],
            [
                '%d',
                '%d',
                '%s',
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
                'message' => __( 'Thank you, your submission is received and will be added to the map once approved by an admin.', 'timeandtidebell-vgm-add-on' ),
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
