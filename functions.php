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
require_once get_stylesheet_directory() . '/inc/author-control.php';
require_once get_stylesheet_directory() . '/inc/admin-dashboard.php';
require_once get_stylesheet_directory() . '/inc/auth.php';
require_once get_stylesheet_directory() . '/inc/restrict.php';
require_once get_stylesheet_directory() . '/inc/branding.php';
require_once get_stylesheet_directory() . '/inc/content-meta.php';
require_once get_stylesheet_directory() . '/inc/shortcodes.php';
require_once get_stylesheet_directory() . '/inc/landing.php';
require_once get_stylesheet_directory() . '/inc/templates.php';
require_once get_stylesheet_directory() . '/inc/comments.php';
require_once get_stylesheet_directory() . '/inc/admin-columns.php';
require_once get_stylesheet_directory() . '/inc/pad.php';

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

add_filter( 'gettext', 'obras_translate_written_by', 20, 3 );
add_filter( 'gettext_with_context', 'obras_translate_written_by_context', 20, 4 );
add_filter( 'render_block', 'obras_translate_written_by_in_blocks', 20, 2 );

function obras_translate_written_by_map( $text ) {
    $map = array(
        'Written by'    => 'Autor:',
        'Written by:'   => 'Autor:',
        'Written by %s' => 'Autor: %s',
        'By'            => 'Autor:',
        'By:'           => 'Autor:',
        'By %s'         => 'Autor: %s',
    );

    return isset( $map[ $text ] ) ? $map[ $text ] : null;
}

function obras_translate_written_by( $translated, $text, $domain ) {
    $replacement = obras_translate_written_by_map( $text );
    return null !== $replacement ? $replacement : $translated;
}

function obras_translate_written_by_context( $translated, $text, $context, $domain ) {
    $replacement = obras_translate_written_by_map( $text );
    return null !== $replacement ? $replacement : $translated;
}

function obras_translate_written_by_in_blocks( $block_content, $block ) {
    if ( is_admin() || '' === $block_content ) {
        return $block_content;
    }

    $block_name = isset( $block['blockName'] ) ? (string) $block['blockName'] : '';
    if ( ! in_array( $block_name, array( 'core/post-author-name', 'core/post-author-biography' ), true ) ) {
        return $block_content;
    }

    $replacements = array(
        'Written by ' => 'Autor: ',
        'Written by'  => 'Autor:',
        'By '         => 'Autor: ',
        'By'          => 'Autor:',
    );

    return strtr( $block_content, $replacements );
}
