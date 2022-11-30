<?php

class Timeandtidebell_Vgm_Add_On_Ajax {

    public $errors = [];

    public function ttb_vgm_form_submit() {
        $nonce = $_POST['nonce'];

        if ( ! wp_verify_nonce( $nonce, 'ttb_vgm_form_nonce' ) ) {
            die( 'Busted!' );
        }

        // sanitize user input
        $data    = $_POST['data'];
        $map_id     = isset( $data['map_id'] ) ? intval( $data['map_id'] ) : 0;
        $date_id     = isset( $data['date_id'] ) ? intval( $data['date_id'] ) : 0;
        $type_id     = isset( $data['type_id'] ) ? intval( $data['type_id'] ) : 0;
        $season_id     = isset( $data['season_id'] ) ? intval( $data['season_id'] ) : 0;
        $wpgmza_ugm_add_address   = isset( $data['wpgmza_ugm_add_address'] ) ? sanitize_text_field( $data['wpgmza_ugm_add_address'] ) : '';
        $ttb_marker_date          = isset( $data['ttb_marker_date'] ) ? sanitize_text_field( $data['ttb_marker_date'] ) : '';
        $ttb_marker_type          = isset( $data['ttb_marker_type'] ) ? sanitize_text_field( $data['ttb_marker_type'] ) : '';
        $ttb_marker_description   = isset( $data['ttb_marker_description'] ) ? sanitize_text_field( $data['ttb_marker_description'] ) : '';

        if ( empty( $ttb_marker_date ) || empty( $wpgmza_ugm_add_address ) || empty( $ttb_marker_type ) || empty( $ttb_marker_description ) ) {
            $this->errors['wpgmza_ugm_add_address']   = __( 'Address is required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_date']          = __( 'Date is required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_type']          = __( 'Type required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_description']   = __( 'Description is required', 'timeandtidebell-vgm-add-on' );
        }

        if ( ! empty( $this->errors ) ) {
            wp_send_json_error( $this->errors );
        }


        global $wpdb;

        $wpgmza_lat_lng = explode(", ", $wpgmza_ugm_add_address);

        //Custom Marker icon Url
        $custom_icon_url        = "";
        $flora_icon_url         = get_site_url().'/wp-content/uploads/wp-google-maps/icons/633ead38835c84.13417171.png';
        $invertebrates_icon_url = get_site_url().'/wp-content/uploads/wp-google-maps/icons/633ead292ba933.27932952.png';
        $crustaceans_icon_url   = get_site_url().'/wp-content/uploads/wp-google-maps/icons/63858c66658a58.29244871.png';
        $fish_icon_url          = get_site_url().'/wp-content/uploads/wp-google-maps/icons/633eadb182d8a0.04915283.png';
        $mammals_icon_url       = get_site_url().'/wp-content/uploads/wp-google-maps/icons/633ead57cf8296.38666914.png';
        $seashells_icon_url     = get_site_url().'/wp-content/uploads/wp-google-maps/icons/633ead292ba933.27932952.png';

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
            ],
            [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
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
}
