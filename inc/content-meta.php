<?php
/**
 * Bitácora de Obra - Campos ACF en single post.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================================
// === MOSTRAR CAMPOS ACF EN SINGLE POST ======================================
// ============================================================================

add_filter( 'the_content', 'obras_display_acf_fields_on_single' );
function obras_display_acf_fields_on_single( $content ) {
    if ( is_admin() || ! is_single() ) {
        return $content;
    }

    $post_type = get_post_type();
    $post_id   = get_the_ID();
    $html      = '';

    // Bitácora
    if ( $post_type === 'bitacora' ) {
        $fecha_raw  = get_post_meta( $post_id, 'fecha_obra', true );
        $archivo_id = get_post_meta( $post_id, 'archivo_adjunto', true );

        $html .= '<div class="obras-acf-box bitacora">';
        $html .= '<h3>📋 Datos de la Entrada</h3>';

        if ( ! empty( $fecha_raw ) ) {
            $fecha_formateada = date_i18n( get_option( 'date_format' ), strtotime( $fecha_raw ) );
        } else {
            $fecha_formateada = get_the_date( get_option( 'date_format' ), $post_id );
        }

        $html .= '<p><strong>📅 Fecha:</strong> ' . esc_html( $fecha_formateada ) . '</p>';

        if ( ! empty( $archivo_id ) ) {
            if ( is_numeric( $archivo_id ) ) {
                $archivo_url      = wp_get_attachment_url( $archivo_id );
                $archivo_filename = get_post_meta( $archivo_id, '_wp_attachment_image_alt', true ) ?: basename( $archivo_url );
                $html .= '<p><strong>📎 Archivo adjunto:</strong> <a href="' . esc_url( $archivo_url ) . '" target="_blank">' . esc_html( $archivo_filename ) . '</a></p>';
            } elseif ( is_array( $archivo_id ) && isset( $archivo_id['url'] ) ) {
                $html .= '<p><strong>📎 Archivo adjunto:</strong> <a href="' . esc_url( $archivo_id['url'] ) . '" target="_blank">' . esc_html( $archivo_id['filename'] ?? basename( $archivo_id['url'] ) ) . '</a></p>';
            }
        }

        $html .= '</div>';
    }

    // Documentos
    if ( $post_type === 'documento_obra' ) {
        $tipo       = get_post_meta( $post_id, 'tipo_documento', true );
        $archivo_id = get_post_meta( $post_id, 'archivo_documento', true );

        $html .= '<div class="obras-acf-box documento">';
        $html .= '<h3>📄 Datos del Documento</h3>';

        if ( ! empty( $tipo ) ) {
            $html .= '<p><strong>Tipo:</strong> ' . esc_html( $tipo ) . '</p>';
        }

        if ( ! empty( $archivo_id ) && is_numeric( $archivo_id ) ) {
            $archivo_url = wp_get_attachment_url( $archivo_id );
            $html .= '<p><strong>📎 Archivo:</strong> <a href="' . esc_url( $archivo_url ) . '" target="_blank">' . esc_html( basename( $archivo_url ) ) . '</a></p>';
        } elseif ( is_array( $archivo_id ) && isset( $archivo_id['url'] ) ) {
            $html .= '<p><strong>📎 Archivo:</strong> <a href="' . esc_url( $archivo_id['url'] ) . '" target="_blank">' . esc_html( $archivo_id['filename'] ?? basename( $archivo_id['url'] ) ) . '</a></p>';
        }

        $html .= '</div>';
    }

    // Materiales
    if ( $post_type === 'material_obra' ) {
        $tipo       = get_post_meta( $post_id, 'tipo_material', true );
        $archivo_id = get_post_meta( $post_id, 'archivo_recurso', true );
        $ubicacion  = get_post_meta( $post_id, 'ubicacion_fisica', true );

        $html .= '<div class="obras-acf-box material">';
        $html .= '<h3>🧰 Datos del Material</h3>';

        if ( ! empty( $tipo ) ) {
            $html .= '<p><strong>Tipo:</strong> ' . esc_html( $tipo ) . '</p>';
        }

        if ( ! empty( $ubicacion ) ) {
            $html .= '<p><strong>📍 Ubicación:</strong> ' . esc_html( $ubicacion ) . '</p>';
        }

        if ( ! empty( $archivo_id ) && is_numeric( $archivo_id ) ) {
            $archivo_url = wp_get_attachment_url( $archivo_id );
            $html .= '<p><strong>📎 Archivo:</strong> <a href="' . esc_url( $archivo_url ) . '" target="_blank">' . esc_html( basename( $archivo_url ) ) . '</a></p>';
        } elseif ( is_array( $archivo_id ) && isset( $archivo_id['url'] ) ) {
            $html .= '<p><strong>📎 Archivo:</strong> <a href="' . esc_url( $archivo_id['url'] ) . '" target="_blank">' . esc_html( $archivo_id['filename'] ?? basename( $archivo_id['url'] ) ) . '</a></p>';
        }

        $html .= '</div>';
    }

    return $content . $html;
}
