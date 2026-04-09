<?php
/**
 * Enqueue scripts and styles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'obras_enqueue_styles' ) ) {

    function obras_enqueue_styles() {

        $parent_style_path     = get_template_directory() . '/style.css';
        $child_style_path      = get_stylesheet_directory() . '/style.css';
        $custom_style_path     = get_stylesheet_directory() . '/css/custom.css';
        $land_style_path       = get_stylesheet_directory() . '/css/landpage.css';
        $dashboard_style_path  = get_stylesheet_directory() . '/css/dashboardfe.css';

        wp_enqueue_style(
            'parent-style',
            get_template_directory_uri() . '/style.css',
                         array(),
                         file_exists( $parent_style_path ) ? filemtime( $parent_style_path ) : wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
        );

        wp_enqueue_style(
            'child-style',
            get_stylesheet_directory_uri() . '/style.css',
                         array( 'parent-style' ),
                         file_exists( $child_style_path ) ? filemtime( $child_style_path ) : wp_get_theme()->get( 'Version' )
        );

        wp_enqueue_style(
            'obras-custom',
            get_stylesheet_directory_uri() . '/css/custom.css',
                         array( 'child-style' ),
                         file_exists( $custom_style_path ) ? filemtime( $custom_style_path ) : null
        );

        if ( is_front_page() ) {
            wp_enqueue_style(
                'obras-land',
                get_stylesheet_directory_uri() . '/css/landpage.css',
                             array( 'obras-custom' ),
                             file_exists( $land_style_path ) ? filemtime( $land_style_path ) : null
            );
        }

        if ( is_user_logged_in() ) {
            wp_enqueue_style(
                'obras-dashboardfe',
                get_stylesheet_directory_uri() . '/css/dashboardfe.css',
                             array( 'obras-custom' ),
                             file_exists( $dashboard_style_path ) ? filemtime( $dashboard_style_path ) : null
            );
        }
    }

    add_action( 'wp_enqueue_scripts', 'obras_enqueue_styles', 10 );
}
