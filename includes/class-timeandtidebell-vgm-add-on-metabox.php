<?php

class timeandtidebell_Vgm_Add_On_MetaBox {
    public function __construct() {
        add_action( 'init', [$this, 'ttb_location_icon_meta'], 0 );
    }

    public function ttb_location_icon_meta(){
        // Control core classes for avoid errors
        if( class_exists( 'CSF' ) ) {

            // Set a unique slug-like ID
            $prefix = 'ttb_location_icon';
        
            // Create customize options
            CSF::createCustomizeOptions( $prefix );
        

            // Create a section
            CSF::createSection( $prefix, array(
            'title'  => 'Types of  Location Icon',
            'fields' => array(
                // A text field
                array(
                    'id'           => 'flora_icon',
                    'type'         => 'upload',
                    'title'        => 'Flora Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Icon',
                    'remove_title' => 'Remove Icon',
                ),
                array(
                    'id'           => 'invertebrates_icon',
                    'type'         => 'upload',
                    'title'        => 'Invertebrates Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Icon',
                    'remove_title' => 'Remove Icon',
                ),
                array(
                    'id'           => 'crustaceans_icon',
                    'type'         => 'upload',
                    'title'        => 'Crustaceans Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Icon',
                    'remove_title' => 'Remove Icon',
                ),
                array(
                    'id'           => 'fish_icon',
                    'type'         => 'upload',
                    'title'        => 'Fish Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Icon',
                    'remove_title' => 'Remove Icon',
                ),
                array(
                    'id'           => 'mammals_icon',
                    'type'         => 'upload',
                    'title'        => 'Mammals Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Icon',
                    'remove_title' => 'Remove Icon',
                ),
                array(
                    'id'           => 'seashells_icon',
                    'type'         => 'upload',
                    'title'        => 'Seashells Icon',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'button_title' => 'Add Icon',
                    'remove_title' => 'Remove Icon',
                ),
        
            )
            ) );
        
        }
        
    }

}

new timeandtidebell_Vgm_Add_On_MetaBox();