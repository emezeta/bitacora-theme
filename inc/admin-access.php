<?php
/**
 * Bitácora de Obra - Admin access control
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_init', 'obras_block_admin_access', 1 );
function obras_block_admin_access() {
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }

    $current   = basename( $_SERVER['PHP_SELF'] );
    $post_type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : '';
    $post_id   = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;

    // Páginas permitidas para usuarios no admin
    $allowed_pages = array(
        'profile.php',
        'user-edit.php',
    );

    if ( in_array( $current, $allowed_pages, true ) ) {
        return;
    }

    // Permitir crear contenido de los CPT del sistema
    if ( $current === 'post-new.php' && in_array( $post_type, array( 'bitacora', 'documento_obra', 'material_obra' ), true ) ) {
        return;
    }

    // Permitir editar contenido existente de los CPT del sistema
    if ( $current === 'post.php' && $post_id ) {
        $edit_post_type = get_post_type( $post_id );

        if ( in_array( $edit_post_type, array( 'bitacora', 'documento_obra', 'material_obra' ), true ) ) {
            return;
        }
    }

    // Permitir listados admin de los CPT del sistema
    if ( $current === 'edit.php' && in_array( $post_type, array( 'bitacora', 'documento_obra', 'material_obra' ), true ) ) {
        return;
    }

    if ( ! headers_sent() ) {
        wp_redirect( home_url( '/' ) );
        exit;
    }
}
