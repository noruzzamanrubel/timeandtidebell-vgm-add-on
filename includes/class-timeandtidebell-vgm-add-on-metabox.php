<?php

class timeandtidebell_Vgm_Add_On_MetaBox {
    public function __construct() {
        add_action( 'init', [$this, 'ttb_location_icon_meta'], 0 );
    }

    public function ttb_location_icon_meta(){
        // Control core classes for avoid errors
        if( class_exists( 'CSF' ) ) {

            //
            // Set a unique slug-like ID
            $prefix = 'ttb_location_default_icon';
        
            //
            // Create customize options
            CSF::createCustomizeOptions( $prefix );
        
            //
            // Create a section
            CSF::createSection( $prefix, array(
            'title'  => 'Default Location Icon',
            'fields' => array(
        
                //
                // A text field
                array(
                    'id'           => 'ttb_location_icon',
                    'type'         => 'upload',
                    'title'        => 'Upload Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Image',
                    'remove_title' => 'Remove Image',
                ),
        
            )
            ) );
        
        }
        
    }

}

new timeandtidebell_Vgm_Add_On_MetaBox();