<?php
/**
 * Bitácora de Obra - Restricciones de acceso
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'template_redirect', 'obras_restrict_pages' );
function obras_restrict_pages() {
    if ( ! is_page() ) {
        return;
    }

    $page = get_queried_object();
    $parent_id = get_option( 'obras_parent_page_id', 0 );

    if ( $parent_id && ( $page->ID == $parent_id || $page->post_parent == $parent_id ) ) {
        $allowed = get_post_meta( $page->ID, '_allowed_users', true );

        if ( ! empty( $allowed ) ) {
            $allowed = array_map( 'intval', (array) $allowed );

            if ( ! is_user_logged_in() || ! in_array( get_current_user_id(), $allowed, true ) ) {
                wp_redirect( wp_login_url( get_permalink() ) );
                exit;
            }
        }
    }
}

add_filter( 'wp_nav_menu_objects', 'obras_filter_menu', 10, 2 );
function obras_filter_menu( $items, $args ) {
    $parent_id = get_option( 'obras_parent_page_id', 0 );

    if ( ! $parent_id ) {
        return $items;
    }

    foreach ( $items as $key => $item ) {
        if ( $item->object !== 'page' ) {
            continue;
        }

        if ( $item->object_id == $parent_id || $item->post_parent == $parent_id ) {
            $allowed = get_post_meta( $item->object_id, '_allowed_users', true );

            if ( ! empty( $allowed ) ) {
                $allowed = array_map( 'intval', (array) $allowed );

                if ( ! is_user_logged_in() || ! in_array( get_current_user_id(), $allowed, true ) ) {
                    unset( $items[ $key ] );
                }
            }
        }
    }

    return $items;
}

// Bloquear acceso directo a CPT si no está logueado
if ( is_singular( array( 'bitacora', 'documento_obra', 'material_obra' ) ) ) {
    if ( ! is_user_logged_in() ) {
        wp_redirect( wp_login_url( get_permalink() ) );
        exit;
    }
}
