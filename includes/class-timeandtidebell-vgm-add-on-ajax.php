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

        //insert data
        $inserted = $wpdb->insert(
            "{$wpdb->prefix}wpgmza",
            [
                'map_id'      => $map_id,
                'address'     => $wpgmza_ugm_add_address,
                'lat'         => $wpgmza_lat_lng[0],
                'lng'         => $wpgmza_lat_lng[1],
                'description' => $ttb_marker_description,
            ],
            [
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );

        // insert custom filed value
        $marker_id = $wpdb->insert_id;
        $wpdb->insert(
            "{$wpdb->prefix}wpgmza_markers_has_custom_fields",
            [
                'object_id' => $marker_id,
                'field_id'  => 3,
                'value'     => $ttb_marker_date,
            ],
            [
                '%d',
                '%d',
                '%s',
            ]
        );

        $wpdb->insert(
            "{$wpdb->prefix}wpgmza_markers_has_custom_fields",
            [
                'object_id' => $marker_id,
                'field_id'  => 4,
                'value'     => $ttb_marker_type,
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
                'message' => __( 'Your marker has been add successfully.', 'timeandtidebell-vgm-add-on' ),
            ], 200 );
        }

        return $wpdb->insert_id;
    }

}
