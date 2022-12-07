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
            'title'  => 'Upload Types of Marker Icon',
            'fields' => array(
                array (
                    'type'         => 'heading',
                    'title'        => 'Flora',
                ),
                array(
                    'id'           => 'flora_icon',
                    'type'         => 'upload',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'preview' => true,
                ),

                array (
                    'type'         => 'heading',
                    'title'        => 'Invertebrates',
                ),
                array(
                    'id'           => 'invertebrates_icon',
                    'type'         => 'upload',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'preview' => true,
                ),

                array (
                    'type'         => 'heading',
                    'title'        => 'Crustaceans',
                ),
                array(
                    'id'           => 'crustaceans_icon',
                    'type'         => 'upload',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'preview' => true,
                ),

                array (
                    'type'         => 'heading',
                    'title'        => 'Fish',
                ),
                array(
                    'id'           => 'fish_icon',
                    'type'         => 'upload',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'preview' => true,
                ),

                array (
                    'type'         => 'heading',
                    'title'        => 'Mammals',
                ),
                array(
                    'id'           => 'mammals_icon',
                    'type'         => 'upload',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'preview' => true,
                ),

                array (
                    'type'         => 'heading',
                    'title'        => 'Seashells',
                ),
                array(
                    'id'           => 'seashells_icon',
                    'type'         => 'upload',
                    'library'      => 'image',
                    'placeholder'  => 'http://',
                    'preview' => true,
                ),
        
            )
            ) );
        
        }
        
    }

}

new timeandtidebell_Vgm_Add_On_MetaBox();