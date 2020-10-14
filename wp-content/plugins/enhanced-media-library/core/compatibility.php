<?php

if ( ! defined( 'ABSPATH' ) )
    exit;



/**
 *  Elementor
 *  @TODO: temporary solution
 *
 *  @since    2.5
 *  @created  28/01/18
 */

add_action( 'elementor/editor/after_enqueue_scripts', 'wpuxss_eml_elementor_scripts' );

if ( ! function_exists( 'wpuxss_eml_elementor_scripts' ) ) {

    function wpuxss_eml_elementor_scripts() {

        global $wpuxss_eml_dir;


        wp_enqueue_style( 'common' );
        wp_enqueue_style(
            'wpuxss-eml-elementor-media-style',
            $wpuxss_eml_dir . 'css/eml-admin-media.css'
        );
    }
}



/**
 *  Enfold Theme
 *  for [av_masonry_gallery] shortcode
 *  use Default Layout and choose the shortcode Media Elements > Masonry Gallery 
 *  to make theme gallery shows images from the specific category
 *
 *  @since    2.7.3
 *  @created  9/10/20
 */
add_filter( 'shortcode_atts_av_masonry_entries', 'wpuxss_eml_shortcode_atts', 10, 3 );
