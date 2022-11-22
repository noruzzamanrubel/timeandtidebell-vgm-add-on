<?php

class timeandtidebell_Vgm_Add_On_Meta_Box {
    public function __construct() {
        add_action( 'init', [$this, 'custom_product_designer_meta_box'], 0 );
    }

    // Register Custom Post Type
    public function custom_product_designer_meta_box() {

        if ( class_exists( 'CSF' ) ) {

            $prefix = 'timeandtidebell_vgm_add_on';

            CSF::createMetabox( $prefix, array(
                'title'     => esc_html__( 'Map Meta', 'oceanwp' ),
                // 'post_type' => 'page',
            ) );

            CSF::createSection( $prefix, array(
                'fields' => array(
                    array(
                        'id'      => 'opt-text',
                        'type'    => 'text',
                        'title'   => 'Text',
                        'default' => 'Hello world.'
                      ),
                ),

            ) );
        }

    }

}

new timeandtidebell_Vgm_Add_On_Meta_Box();