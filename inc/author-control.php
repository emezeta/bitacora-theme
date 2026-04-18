<?php
/**
 * Bitácora de Obra - Control de autoría en creación/edición.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Post types controlados por Bitácora.
 * Catálogos y Planos entran por material_obra.
 */
function obras_author_locked_post_types() {
    return array( 'bitacora', 'documento_obra', 'material_obra' );
}

/**
 * Oculta el metabox "Autor" para usuarios no admin.
 */
add_action( 'add_meta_boxes', 'obras_hide_author_metabox_for_non_admin', 99, 2 );
function obras_hide_author_metabox_for_non_admin( $post_type, $post ) {
    if ( ! is_admin() ) {
        return;
    }

    // El admin sí puede elegir autor.
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( ! in_array( $post_type, obras_author_locked_post_types(), true ) ) {
        return;
    }

    // Lo removemos en todas las ubicaciones posibles por seguridad.
    remove_meta_box( 'authordiv', $post_type, 'normal' );
    remove_meta_box( 'authordiv', $post_type, 'side' );
    remove_meta_box( 'authordiv', $post_type, 'advanced' );
}

/**
 * Fuerza que el autor sea siempre el usuario logueado
 * cuando quien guarda NO es admin.
 */
add_filter( 'wp_insert_post_data', 'obras_force_current_user_as_author', 99, 2 );
function obras_force_current_user_as_author( $data, $postarr ) {
    if ( ! is_admin() ) {
        return $data;
    }

    if ( current_user_can( 'manage_options' ) ) {
        return $data;
    }

    if ( empty( $data['post_type'] ) ) {
        return $data;
    }

    if ( ! in_array( $data['post_type'], obras_author_locked_post_types(), true ) ) {
        return $data;
    }

    if ( ! is_user_logged_in() ) {
        return $data;
    }

    // Blindaje real del autor.
    $data['post_author'] = get_current_user_id();

    return $data;
}
