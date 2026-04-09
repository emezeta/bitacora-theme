<?php
/**
 * Bitácora de Obra - Template para Frontend.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================================
// === FORZAR TEMPLATE PARA LISTADOS FRONTEND =================================
// ============================================================================

add_filter( 'template_include', 'obras_force_page_template_for_listados', 999 );
function obras_force_page_template_for_listados( $template ) {
    if ( is_admin() ) {
        return $template;
    }

    $slugs = array( 'documentos', 'materiales', 'entradas' );
    $slug = get_query_var( 'name' );

    if ( in_array( $slug, $slugs, true ) ) {
        $page = get_page_by_path( $slug );
        if ( $page && $page->post_status === 'publish' && $page->post_type === 'page' ) {
            $t = locate_template( 'page.php' );
            if ( $t ) {
                return $t;
            }
        }
    }

    return $template;
}
