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
                'required' => 1,
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
                    'foto' => 'Foto',
                    'video' => 'Video',
                    'muestra' => 'Muestra',
                    'catalogo' => 'Catálogo',
                    'plano' => 'Plano',
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
