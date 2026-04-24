<?php
/**
 * Bitácora de Obra - Limpieza del editor clásico
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Post types gestionados por Bitácora.
 */
if ( ! function_exists( 'obras_editor_cleanup_post_types' ) ) {
    function obras_editor_cleanup_post_types() {
        return array(
            'bitacora',
            'documento_obra',
            'material_obra',
            'catalogo_obra',
            'plano_obra',
        );
    }
}

/**
 * Detecta el post type actual en pantallas de edición.
 */
if ( ! function_exists( 'obras_get_current_editor_post_type' ) ) {
    function obras_get_current_editor_post_type() {
        $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

        if ( $screen && ! empty( $screen->post_type ) ) {
            return $screen->post_type;
        }

        if ( isset( $_GET['post_type'] ) ) {
            return sanitize_key( wp_unslash( $_GET['post_type'] ) );
        }

        if ( isset( $_GET['post'] ) ) {
            return get_post_type( absint( $_GET['post'] ) );
        }

        if ( isset( $_POST['post_type'] ) ) {
            return sanitize_key( wp_unslash( $_POST['post_type'] ) );
        }

        if ( isset( $_POST['post_ID'] ) ) {
            return get_post_type( absint( $_POST['post_ID'] ) );
        }

        return '';
    }
}

/**
 * Indica si estamos en un editor clásico de un ndmcp de Bitácora.
 */
if ( ! function_exists( 'obras_is_managed_editor_screen' ) ) {
    function obras_is_managed_editor_screen() {
        if ( ! is_admin() ) {
            return false;
        }

        $post_type = obras_get_current_editor_post_type();
        if ( ! $post_type ) {
            return false;
        }

        return in_array( $post_type, obras_editor_cleanup_post_types(), true );
    }
}

/**
 * Oculta el bloque visual del permalink / enlace permanente.
 */
add_filter( 'get_sample_permalink_html', 'obras_hide_sample_permalink_html', 10, 5 );
function obras_hide_sample_permalink_html( $return, $post_id, $new_title, $new_slug, $post ) {
    if ( $post instanceof WP_Post && in_array( $post->post_type, obras_editor_cleanup_post_types(), true ) ) {
        return '';
    }

    return $return;
}

/**
 * Capa extra de CSS para limpiar restos del permalink si aparecieran.
 */
add_action( 'admin_head', 'obras_hide_permalink_css' );
function obras_hide_permalink_css() {
    if ( ! obras_is_managed_editor_screen() ) {
        return;
    }
    ?>
    <style>
        #edit-slug-box,
        .edit-slug-box,
        #sample-permalink,
        .editor-post-permalink {
            display: none !important;
        }
    </style>
    <?php
}

/**
 * Quita el botón "Más" del editor visual.
 */
add_filter( 'mce_buttons', 'obras_remove_more_button_from_visual_editor' );
function obras_remove_more_button_from_visual_editor( $buttons ) {
    if ( ! obras_is_managed_editor_screen() ) {
        return $buttons;
    }

    $to_remove = array( 'wp_more' );
    return array_values( array_diff( $buttons, $to_remove ) );
}

/**
 * Quita el botón "Más" del editor de texto.
 */
add_filter( 'quicktags_settings', 'obras_remove_more_button_from_text_editor', 10, 2 );
function obras_remove_more_button_from_text_editor( $qt_init, $editor_id ) {
    if ( ! obras_is_managed_editor_screen() ) {
        return $qt_init;
    }

    if ( empty( $qt_init['buttons'] ) ) {
        return $qt_init;
    }

    $buttons = array_map( 'trim', explode( ',', $qt_init['buttons'] ) );
    $buttons = array_values( array_diff( $buttons, array( 'more' ) ) );
    $qt_init['buttons'] = implode( ',', $buttons );

    return $qt_init;
}
