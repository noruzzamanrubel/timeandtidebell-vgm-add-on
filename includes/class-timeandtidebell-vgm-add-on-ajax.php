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
        $id      = isset( $data['id'] ) ? intval( $data['id'] ) : 0;
        $ttb_marker_date   = isset( $data['ttb_marker_date'] ) ? sanitize_text_field( $data['ttb_marker_date'] ) : '';
        $ttb_marker_address   = isset( $data['ttb_marker_address'] ) ? sanitize_text_field( $data['ttb_marker_address'] ) : '';
        $ttb_marker_type   = isset( $data['ttb_marker_type'] ) ? sanitize_text_field( $data['ttb_marker_type'] ) : '';
        $ttb_marker_description   = isset( $data['ttb_marker_description'] ) ? sanitize_text_field( $data['ttb_marker_description'] ) : '';

        // validate user input
        if ( empty( $ttb_marker_date ) || empty( $ttb_marker_address ) || empty( $ttb_marker_type ) || empty( $ttb_marker_description ) ) {
            $this->errors['ttb_marker_date']   = __( 'Date is required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_address']   = __( 'Address is required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_type']   = __( 'Type required', 'timeandtidebell-vgm-add-on' );
            $this->errors['ttb_marker_description'] = __( 'Description is required', 'timeandtidebell-vgm-add-on' );
        }

        if ( ! empty( $this->errors ) ) {
            wp_send_json_error( $this->errors );
        }

        wp_send_json_success( [
            'message' => __( 'Your message has been sent successfully.', 'timeandtidebell-vgm-add-on' ),
        ], 200 );

    }

}
