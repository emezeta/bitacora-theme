<?php
/**
 * Bitácora de Obra - Child Theme Functions
 * Parent: Twenty Twenty-Five
 * Version: 1.2.6
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================================
// === MÓDULOS DEL THEME  =====================================================
// ============================================================================

require_once get_stylesheet_directory() . '/inc/enqueue.php';
require_once get_stylesheet_directory() . '/inc/cpt.php';
require_once get_stylesheet_directory() . '/inc/acf.php';
require_once get_stylesheet_directory() . '/inc/kiosk.php';
require_once get_stylesheet_directory() . '/inc/admin-access.php';
require_once get_stylesheet_directory() . '/inc/admin-dashboard.php';
require_once get_stylesheet_directory() . '/inc/auth.php';
require_once get_stylesheet_directory() . '/inc/restrict.php';
require_once get_stylesheet_directory() . '/inc/branding.php';
require_once get_stylesheet_directory() . '/inc/content-meta.php';
require_once get_stylesheet_directory() . '/inc/shortcodes.php';
require_once get_stylesheet_directory() . '/inc/landing.php';
require_once get_stylesheet_directory() . '/inc/templates.php';


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

