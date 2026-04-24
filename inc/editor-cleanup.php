<?php
/**
 * Bitácora de Obra - Limpieza y política del editor clásico
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
 * Post types que pueden tener botón Enlace.
 * - Notas: enlace externo + interno
 * - Documentos / Materiales / Catálogos: sólo externo
 * - Planos: sin enlace
 */
if ( ! function_exists( 'obras_post_types_with_link_button' ) ) {
    function obras_post_types_with_link_button() {
        return array(
            'bitacora',
            'documento_obra',
            'material_obra',
            'catalogo_obra',
        );
    }
}

/**
 * Post types que admiten búsqueda interna en el diálogo de Enlace.
 * Por política actual, sólo las Notas.
 */
if ( ! function_exists( 'obras_post_types_with_internal_link_search' ) ) {
    function obras_post_types_with_internal_link_search() {
        return array( 'bitacora' );
    }
}

/**
 * Destinos internos válidos para enlaces desde Notas.
 */
if ( ! function_exists( 'obras_allowed_internal_link_targets' ) ) {
    function obras_allowed_internal_link_targets() {
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
 * Detecta el post type actual en pantallas de edición normales o AJAX.
 */
if ( ! function_exists( 'obras_get_current_editor_post_type' ) ) {
    function obras_get_current_editor_post_type() {
        $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

        if ( $screen && ! empty( $screen->post_type ) ) {
            return $screen->post_type;
        }

        $request_keys = array( 'post_type', 'post', 'post_ID', 'post_id' );

        foreach ( $request_keys as $key ) {
            if ( empty( $_REQUEST[ $key ] ) ) {
                continue;
            }

            if ( 'post_type' === $key ) {
                return sanitize_key( wp_unslash( $_REQUEST[ $key ] ) );
            }

            $post_type = get_post_type( absint( $_REQUEST[ $key ] ) );
            if ( $post_type ) {
                return $post_type;
            }
        }

        if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
            $ref_query = wp_parse_url( wp_unslash( $_SERVER['HTTP_REFERER'] ), PHP_URL_QUERY );

            if ( $ref_query ) {
                parse_str( $ref_query, $ref_args );

                if ( ! empty( $ref_args['post_type'] ) ) {
                    return sanitize_key( $ref_args['post_type'] );
                }

                foreach ( array( 'post', 'post_ID', 'post_id' ) as $key ) {
                    if ( empty( $ref_args[ $key ] ) ) {
                        continue;
                    }

                    $post_type = get_post_type( absint( $ref_args[ $key ] ) );
                    if ( $post_type ) {
                        return $post_type;
                    }
                }
            }
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
 * Indica si el ndmcp actual debe mostrar el botón Enlace.
 */
if ( ! function_exists( 'obras_current_editor_allows_link_button' ) ) {
    function obras_current_editor_allows_link_button() {
        $post_type = obras_get_current_editor_post_type();

        return in_array( $post_type, obras_post_types_with_link_button(), true );
    }
}

/**
 * Indica si el ndmcp actual debe permitir búsqueda interna desde el diálogo de Enlace.
 */
if ( ! function_exists( 'obras_current_editor_allows_internal_link_search' ) ) {
    function obras_current_editor_allows_internal_link_search() {
        $post_type = obras_get_current_editor_post_type();

        return in_array( $post_type, obras_post_types_with_internal_link_search(), true );
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
 * Limpia botones del editor visual según política.
 */
add_filter( 'mce_buttons', 'obras_filter_visual_editor_buttons' );
function obras_filter_visual_editor_buttons( $buttons ) {
    if ( ! obras_is_managed_editor_screen() ) {
        return $buttons;
    }

    $to_remove = array( 'wp_more' );

    if ( ! obras_current_editor_allows_link_button() ) {
        $to_remove[] = 'link';
        $to_remove[] = 'unlink';
    }

    return array_values( array_diff( $buttons, $to_remove ) );
}

/**
 * Limpia botones del editor de texto según política.
 */
add_filter( 'quicktags_settings', 'obras_filter_text_editor_buttons', 10, 2 );
function obras_filter_text_editor_buttons( $qt_init, $editor_id ) {
    if ( ! obras_is_managed_editor_screen() ) {
        return $qt_init;
    }

    if ( empty( $qt_init['buttons'] ) ) {
        return $qt_init;
    }

    $buttons = array_map( 'trim', explode( ',', $qt_init['buttons'] ) );
    $buttons = array_values( array_diff( $buttons, array( 'more' ) ) );

    if ( ! obras_current_editor_allows_link_button() ) {
        $buttons = array_values( array_diff( $buttons, array( 'link' ) ) );
    }

    $qt_init['buttons'] = implode( ',', $buttons );

    return $qt_init;
}

/**
 * Restringe la búsqueda interna del diálogo Enlace según el ndmcp actual.
 */
add_filter( 'wp_link_query_args', 'obras_filter_internal_link_query_args' );
function obras_filter_internal_link_query_args( $query ) {
    $post_type = obras_get_current_editor_post_type();

    if ( ! in_array( $post_type, obras_editor_cleanup_post_types(), true ) ) {
        return $query;
    }

    if ( obras_current_editor_allows_internal_link_search() ) {
        $query['post_type'] = obras_allowed_internal_link_targets();
        return $query;
    }

    $query['post_type'] = array( 'obras_internal_links_disabled' );

    return $query;
}

/**
 * Ajusta resultados del diálogo Enlace.
 * - En Notas: conserva ndmcp válidos y agrega medios por búsqueda.
 * - En Documentos / Materiales / Catálogos / Planos: sin resultados internos.
 */
add_filter( 'wp_link_query', 'obras_filter_internal_link_query_results', 10, 2 );
function obras_filter_internal_link_query_results( $results, $query ) {
    $post_type = obras_get_current_editor_post_type();

    if ( ! in_array( $post_type, obras_editor_cleanup_post_types(), true ) ) {
        return $results;
    }

    if ( ! obras_current_editor_allows_internal_link_search() ) {
        return array();
    }

    $allowed_targets = obras_allowed_internal_link_targets();
    $clean_results   = array();
    $seen_urls       = array();

    foreach ( (array) $results as $result ) {
        if ( empty( $result['ID'] ) ) {
            continue;
        }

        $target_post_type = get_post_type( (int) $result['ID'] );
        if ( ! in_array( $target_post_type, $allowed_targets, true ) ) {
            continue;
        }

        if ( empty( $result['permalink'] ) || isset( $seen_urls[ $result['permalink'] ] ) ) {
            continue;
        }

        $seen_urls[ $result['permalink'] ] = true;
        $clean_results[]                   = $result;
    }

    // Agregar medios sólo para Notas, como resultados extra del diálogo de enlace.
    $search_term = isset( $query['s'] ) ? trim( (string) $query['s'] ) : '';

    if ( '' !== $search_term ) {
        $media_query = new WP_Query( array(
            'post_type'              => 'attachment',
            'post_status'            => 'inherit',
            'posts_per_page'         => 20,
            'orderby'                => 'date',
            'order'                  => 'DESC',
            's'                      => $search_term,
            'suppress_filters'       => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'no_found_rows'          => true,
        ) );

        foreach ( $media_query->posts as $attachment ) {
            $media_url = wp_get_attachment_url( $attachment->ID );

            if ( ! $media_url || isset( $seen_urls[ $media_url ] ) ) {
                continue;
            }

            $title = trim( wp_strip_all_tags( get_the_title( $attachment->ID ) ) );
            if ( '' === $title ) {
                $title = basename( $media_url );
            }

            $seen_urls[ $media_url ] = true;
            $clean_results[] = array(
                'ID'        => (int) $attachment->ID,
                                     'title'     => esc_html( $title ),
                                     'permalink' => esc_url_raw( $media_url ),
                                     'info'      => 'Medio',
            );
        }
    }

    return $clean_results;
}
