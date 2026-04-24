<?php
/**
 * Bitácora de Obra - Template para Frontend.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Slugs de páginas de listados frontend.
 */
if ( ! function_exists( 'obras_get_listado_page_slugs' ) ) {
    function obras_get_listado_page_slugs() {
        return array(
            'entradas',
            'documentos',
            'materiales',
            'catalogos',
            'planos',
        );
    }
}

// ============================================================================
// === FORZAR TEMPLATE PARA LISTADOS FRONTEND =================================
// ============================================================================

add_filter( 'template_include', 'obras_force_page_template_for_listados', 999 );
function obras_force_page_template_for_listados( $template ) {
    if ( is_admin() ) {
        return $template;
    }

    $slugs = obras_get_listado_page_slugs();

    if ( ! is_page( $slugs ) ) {
        return $template;
    }

    $page = get_queried_object();

    if ( ! $page instanceof WP_Post ) {
        return $template;
    }

    if ( 'page' !== $page->post_type || 'publish' !== $page->post_status ) {
        return $template;
    }

    $page_template = locate_template( 'page.php' );
    if ( $page_template ) {
        return $page_template;
    }

    return $template;
}
