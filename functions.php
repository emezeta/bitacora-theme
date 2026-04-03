<?php
/**
 * Bitácora de Obra - Child Theme Functions
 * Folder: wp-content/themes/twentytwentyfive-child
 * Parent: Twenty Twenty-Five
 * Archivo: functions.php
 * Version: 1.1.5
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ✅ NUEVO: cargar enqueue separado
require_once get_stylesheet_directory() . '/inc/enqueue.php';


// ============================================================================
// === DESACTIVAR GUTENBERG / FORZAR CLASSIC EDITOR ===========================
// ============================================================================

add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
add_filter( 'use_block_editor_for_post', '__return_false', 100 );
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
remove_theme_support( 'core-block-patterns' );
remove_theme_support( 'block-templates' );

add_filter( 'classic_editor_enabled_editors', function( $editors ) {
    return array( 'classic' => true );
} );


// ============================================================================
// === CUSTOM POST TYPES (3 entidades base) ===================================
// ============================================================================

function obras_register_bitacora_cpt() {
    register_post_type( 'bitacora', array(
        'labels' => array(
            'name' => 'Bitácora',
            'singular_name' => 'Entrada',
            'add_new' => 'Nueva Entrada',
            'menu_name' => 'Bitácora',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'bitacora-cpt' ),
                                          'supports' => array( 'title', 'editor', 'author' ),
                                          'menu_icon' => 'dashicons-book',
                                          'menu_position' => 2,
                                          'show_in_rest' => false,
    ));
}

function obras_register_documento_cpt() {
    register_post_type( 'documento_obra', array(
        'labels' => array(
            'name' => 'Documentos',
            'singular_name' => 'Documento',
            'add_new' => 'Nuevo Documento',
            'menu_name' => 'Documentos',
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array( 'slug' => 'documentos-cpt' ),
                                                'supports' => array( 'title', 'editor', 'author' ),
                                                'menu_icon' => 'dashicons-media-document',
                                                'menu_position' => 3,
                                                'show_in_rest' => false,
                                                'show_in_menu' => 'edit.php?post_type=bitacora',
    ));
}

function obras_register_material_cpt() {
    register_post_type( 'material_obra', array(
        'labels' => array(
            'name' => 'Materiales',
            'singular_name' => 'Material',
            'add_new' => 'Nuevo Material',
            'menu_name' => 'Materiales',
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array( 'slug' => 'materiales-cpt' ),
                                               'supports' => array( 'title', 'editor', 'thumbnail' ),
                                               'menu_icon' => 'dashicons-archive',
                                               'menu_position' => 4,
                                               'show_in_rest' => false,
                                               'show_in_menu' => 'edit.php?post_type=bitacora',
    ));
}

add_action( 'init', 'obras_register_bitacora_cpt' );
add_action( 'init', 'obras_register_documento_cpt' );
add_action( 'init', 'obras_register_material_cpt' );

