<?php
/**
 * Bitácora de Obra - Child Theme Functions
 * Folder: wp-content/themes/twentytwentyfive-child
 * Parent: Twenty Twenty-Five
 * Archivo: inc/enqueue.php
 * Version: 1.1.5
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', 'obras_enqueue_styles', 10 );

function obras_enqueue_styles() {

    // Parent theme stylesheet
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
    );

    // Child theme stylesheet
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        wp_get_theme()->get( 'Version' )
    );

    // Base CSS
    wp_enqueue_style(
        'obras-custom',
        get_stylesheet_directory_uri() . '/css/custom.css',
        array( 'child-style' ),
        '2.0.0'
    );

    // Landing (home)
    if ( is_front_page() ) {
        wp_enqueue_style(
            'obras-land',
            get_stylesheet_directory_uri() . '/css/landpage.css',
            array( 'obras-custom' ),
            '2.0.0'
        );
    }

    // Dashboard frontend
    if ( is_user_logged_in() ) {
        wp_enqueue_style(
            'obras-dashboardfe',
            get_stylesheet_directory_uri() . '/css/dashboardfe.css',
            array( 'obras-custom' ),
            '2.0.0'
        );
    }
}
