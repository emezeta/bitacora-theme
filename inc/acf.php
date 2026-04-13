<?php
/**
 *  ACF: CAMPOS VÍA CÓDIGO (sin UI)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================================
// === ACF: CAMPOS VÍA CÓDIGO (sin UI) ========================================
// ============================================================================

if ( function_exists( 'acf_add_local_field_group' ) ) :

    // Bitácora
    acf_add_local_field_group( array(
        'key' => 'group_bitacora_obras',
        'title' => 'Datos de Entrada',
        'fields' => array(
            array(
                'key' => 'field_fecha',
                'label' => 'Fecha',
                'name' => 'fecha_obra',
                'type' => 'date_picker',
                'date_format' => 'Y-m-d',
                'display_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_archivo',
                'label' => 'Archivo Adjunto',
                'name' => 'archivo_adjunto',
                'type' => 'file',
                'return_format' => 'array',
                'mime_types' => 'pdf,doc,docx,jpg,png',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'bitacora',
                ),
            ),
        ),
        'position' => 'normal',
        'label_placement' => 'top',
    ) );

    // Documentos
    acf_add_local_field_group( array(
        'key' => 'group_documento_obras',
        'title' => 'Datos del Documento',
        'fields' => array(
            array(
                'key' => 'field_tipo',
                'label' => 'Tipo',
                'name' => 'tipo_documento',
                'type' => 'select',
                'choices' => array(
                    'nota' => 'Nota',
                    'memo' => 'Memo',
                    'instructivo' => 'Instructivo',
                ),
            ),
            array(
                'key' => 'field_archivo_doc',
                'label' => 'Archivo',
                'name' => 'archivo_documento',
                'type' => 'file',
                'return_format' => 'array',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'documento_obra',
                ),
            ),
        ),
        'position' => 'normal',
        'label_placement' => 'top',
    ) );

    // Materiales
    acf_add_local_field_group( array(
        'key' => 'group_material_obras',
        'title' => 'Datos del Material',
        'fields' => array(
            array(
                'key' => 'field_tipo_mat',
                'label' => 'Tipo',
                'name' => 'tipo_material',
                'type' => 'select',
                'choices' => array(
                    'foto'     => 'Foto',
                    'video'    => 'Video',
                    'muestra'  => 'Muestra',
                    'catalogo' => 'Catálogo',
                    'plano'    => 'Plano',
                ),
            ),
            array(
                'key' => 'field_archivo_mat',
                'label' => 'Archivo',
                'name' => 'archivo_recurso',
                'type' => 'file',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_ubicacion',
                'label' => 'Ubicación Física',
                'name' => 'ubicacion_fisica',
                'type' => 'text',
                'placeholder' => 'Ej: Galpón B, Estante 3',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'material_obra',
                ),
            ),
        ),
        'position' => 'normal',
        'label_placement' => 'top',
    ) );

endif;


// ============================================================================
// === PRECARGAR tipo_material DESDE URL EN NUEVO MATERIAL ====================
// ============================================================================

add_filter( 'acf/load_value/name=tipo_material', 'obras_prefill_tipo_material_from_url', 10, 3 );
function obras_prefill_tipo_material_from_url( $value, $post_id, $field ) {
    if ( ! is_admin() ) {
        return $value;
    }

    if ( ! empty( $value ) ) {
        return $value;
    }

    if ( empty( $_GET['post_type'] ) || 'material_obra' !== $_GET['post_type'] ) {
        return $value;
    }

    if ( empty( $_GET['tipo_material'] ) ) {
        return $value;
    }

    $allowed = array( 'foto', 'video', 'muestra', 'catalogo', 'plano' );
    $tipo    = sanitize_key( wp_unslash( $_GET['tipo_material'] ) );

    if ( in_array( $tipo, $allowed, true ) ) {
        return $tipo;
    }

    return $value;
}


// ============================================================================
// === AYUDA CONTEXTUAL EN CAMPO ARCHIVO (MATERIALES) =========================
// ============================================================================

add_action( 'admin_footer', 'obras_material_archivo_help_tooltip' );
function obras_material_archivo_help_tooltip() {
    // if ( ! is_admin() ) {
    //     return;
    // }

    $screen = get_current_screen();
    if ( ! $screen ) {
        return;
    }

    if ( $screen->base !== 'post' ) {
        return;
    }

    if ( $screen->post_type !== 'material_obra' ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var field = document.querySelector('.acf-field[data-name="archivo_recurso"]');
        if (!field) {
            return;
        }

        var label = field.querySelector('.acf-label label');
        if (!label) {
            return;
        }

        if (field.querySelector('.obras-help-trigger')) {
            return;
        }

        var trigger = document.createElement('button');
        trigger.type = 'button';
    trigger.className = 'obras-help-trigger';
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('title', 'Ayuda');
    trigger.textContent = '?';

    var popup = document.createElement('div');
    popup.className = 'obras-help-popup';
    popup.hidden = true;
    popup.innerHTML = 'Adjunta un archivo a esta publicación.<br>Quedará asociado a este material y también disponible en la biblioteca de Bitácora.';

    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        var isHidden = popup.hidden;
        popup.hidden = !isHidden;
        trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    });

    document.addEventListener('click', function(e) {
        if (!field.contains(e.target)) {
            popup.hidden = true;
            trigger.setAttribute('aria-expanded', 'false');
        }
    });

    label.style.display = 'inline-flex';
    label.style.alignItems = 'center';
    label.style.gap = '8px';

    label.appendChild(trigger);
    field.querySelector('.acf-label').appendChild(popup);
    });
    </script>

    <style>
    .acf-field[data-name="archivo_recurso"] .acf-label {
        position: relative;
    }

    .obras-help-trigger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border: 1px solid #2271b1;
        border-radius: 50%;
        background: #fff;
        color: #2271b1;
        font-weight: 700;
        font-size: 13px;
        line-height: 1;
        cursor: pointer;
        padding: 0;
    }

    .obras-help-trigger:hover,
    .obras-help-trigger:focus {
        background: #2271b1;
        color: #fff;
        outline: none;
    }

    .obras-help-popup {
        margin-top: 10px;
        max-width: 460px;
        padding: 12px 14px;
        background: #fff;
        border: 1px solid #ccd0d4;
        border-left: 4px solid #2271b1;
        border-radius: 6px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        color: #1d2327;
        font-size: 13px;
        line-height: 1.45;
    }
    </style>
    <?php
}


