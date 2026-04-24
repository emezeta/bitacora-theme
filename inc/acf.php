<?php
/**
 *  ACF: CAMPOS VÍA CÓDIGO (sin UI)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

<<<<<<< Updated upstream
=======
if ( ! function_exists( 'obras_get_document_class_choices' ) ) {
    function obras_get_document_class_choices() {
        return array(
            'memo'          => 'Memo',
            'instructivo'   => 'Instructivo',
            'informe'       => 'Informe',
            'estado_cuenta' => 'Estado de cuenta',
        );
    }
}

if ( ! function_exists( 'obras_get_material_class_choices' ) ) {
    function obras_get_material_class_choices() {
        return array(
            'foto'        => 'Foto',
            'video'       => 'Video',
            'muestra'     => 'Muestra',
            'insumo'      => 'Insumo',
            'observacion' => 'Observación',
            'referencia'  => 'Referencia',
        );
    }
}

if ( ! function_exists( 'obras_get_catalogo_plano_class_choices' ) ) {
    function obras_get_catalogo_plano_class_choices() {
        return array(
            'referencia'  => 'Referencia',
            'tecnico'     => 'Técnico',
            'explicacion' => 'Explicación',
            'observacion' => 'Observación',
            'novedad'     => 'Novedad',
        );
    }
}

if ( ! function_exists( 'obras_get_post_class_label' ) ) {
    function obras_get_post_class_label( $post_id ) {
        $post_type = get_post_type( $post_id );
        $value     = '';
        $choices   = array();

        switch ( $post_type ) {
            case 'documento_obra':
                $value   = get_post_meta( $post_id, 'tipo_documento', true );
                $choices = obras_get_document_class_choices();
                break;

            case 'material_obra':
                $value   = get_post_meta( $post_id, 'clase_material', true );
                $choices = obras_get_material_class_choices();
                break;

            case 'catalogo_obra':
                $value   = get_post_meta( $post_id, 'clase_catalogo', true );
                $choices = obras_get_catalogo_plano_class_choices();
                break;

            case 'plano_obra':
                $value   = get_post_meta( $post_id, 'clase_plano', true );
                $choices = obras_get_catalogo_plano_class_choices();
                break;
        }

        if ( $value && isset( $choices[ $value ] ) ) {
            return $choices[ $value ];
        }

        return '';
    }
}

>>>>>>> Stashed changes
// ============================================================================
// === ACF: CAMPOS VÍA CÓDIGO (sin UI) ========================================
// ============================================================================

if ( function_exists( 'acf_add_local_field_group' ) ) :

    // Bitácora
    acf_add_local_field_group( array(
        'key' => 'group_bitacora_obras',
        'title' => 'Datos de la Nota',
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
                'label' => 'Adjuntar archivo',
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
                'key' => 'field_tipo_documento',
                'label' => 'Clase del contenido',
                'name' => 'tipo_documento',
                'type' => 'select',
                'choices' => obras_get_document_class_choices(),
                  'allow_null' => 1,
                  'return_format' => 'value',
            ),
            array(
                'key' => 'field_archivo_doc',
                'label' => 'Adjuntar archivo',
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
                'key' => 'field_clase_mat',
                'label' => 'Clase del contenido',
                'name' => 'clase_material',
                'type' => 'select',
<<<<<<< Updated upstream
                'choices' => array(
                    'foto'     => 'Foto',
                    'video'    => 'Video',
                    'muestra'  => 'Muestra',
                    'catalogo' => 'Catálogo',
                    'plano'    => 'Plano',
                ),
=======
                'choices' => obras_get_material_class_choices(),
                  'allow_null' => 1,
                  'return_format' => 'value',
>>>>>>> Stashed changes
            ),
            array(
                'key' => 'field_archivo_mat',
                'label' => 'Adjuntar archivo',
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

<<<<<<< Updated upstream
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
// === AYUDA CONTEXTUAL EN CAMPOS ACF DE ARCHIVO ==============================
// ============================================================================

add_action( 'admin_footer', 'obras_acf_file_field_help_tooltips' );
function obras_acf_file_field_help_tooltips() {
    if ( ! is_admin() ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen ) {
        return;
    }

    if ( 'post' !== $screen->base ) {
        return;
    }

    $allowed_post_types = array( 'bitacora', 'documento_obra', 'material_obra' );
    if ( ! in_array( $screen->post_type, $allowed_post_types, true ) ) {
        return;
    }

    $file_help_map = array(
        'archivo_adjunto'  => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
        'archivo_documento' => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
        'archivo_recurso'   => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
    );

    $media_help = 'Usa “Añadir medios” para insertar una foto o imagen dentro del texto. Usa “Adjuntar archivo” para dejar un archivo asociado a la publicación.';
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileHelpMap = <?php echo wp_json_encode( $file_help_map ); ?>;
        var mediaHelp   = <?php echo wp_json_encode( $media_help ); ?>;

        function closeAllHelps(exceptPopup, exceptTrigger) {
            document.querySelectorAll('.obras-help-popup').forEach(function(otherPopup) {
                if (otherPopup !== exceptPopup) {
                    otherPopup.hidden = true;
                }
            });

            document.querySelectorAll('.obras-help-trigger').forEach(function(otherTrigger) {
                if (otherTrigger !== exceptTrigger) {
                    otherTrigger.setAttribute('aria-expanded', 'false');
                }
            });
        }

        function buildHelpTrigger(text) {
            var trigger = document.createElement('button');
            trigger.type = 'button';
    trigger.className = 'obras-help-trigger';
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('title', 'Ayuda');
    trigger.textContent = '?';

    var popup = document.createElement('div');
    popup.className = 'obras-help-popup';
    popup.hidden = true;
    popup.innerHTML = text;

    trigger.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var isHidden = popup.hidden;
        closeAllHelps(popup, trigger);
        popup.hidden = !isHidden;
        trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    });

    return { trigger: trigger, popup: popup };
        }

        // --------------------------------------------------------------------
        // Ayuda en campos ACF de archivo
        // --------------------------------------------------------------------
        Object.keys(fileHelpMap).forEach(function(fieldName) {
            var field = document.querySelector('.acf-field[data-name="' + fieldName + '"]');
            if (!field) {
                return;
            }

            var label = field.querySelector('.acf-label label');
            var labelWrap = field.querySelector('.acf-label');

            if (!label || !labelWrap) {
                return;
            }

            if (field.querySelector('.obras-help-trigger')) {
                return;
            }

            var help = buildHelpTrigger(fileHelpMap[fieldName]);

            label.style.display = 'inline-flex';
        label.style.alignItems = 'center';
        label.style.gap = '8px';

        label.appendChild(help.trigger);
        labelWrap.appendChild(help.popup);
        });

        // --------------------------------------------------------------------
        // Ayuda en botón "Añadir medios" del editor clásico
        // --------------------------------------------------------------------
        var mediaButton = document.querySelector('.wp-media-buttons .insert-media');
        var mediaWrap   = document.querySelector('.wp-media-buttons');

        if (mediaButton && mediaWrap && !mediaWrap.querySelector('.obras-media-help-anchor')) {
            var anchor = document.createElement('span');
            anchor.className = 'obras-media-help-anchor';
    anchor.style.position = 'relative';
    anchor.style.display = 'inline-flex';
    anchor.style.alignItems = 'center';
    anchor.style.marginLeft = '8px';

    var mediaHelpParts = buildHelpTrigger(mediaHelp);

    anchor.appendChild(mediaHelpParts.trigger);
    anchor.appendChild(mediaHelpParts.popup);
    mediaWrap.appendChild(anchor);
        }

        document.addEventListener('click', function(e) {
            document.querySelectorAll('.obras-help-popup').forEach(function(popup) {
                var parent = popup.parentElement ? popup.parentElement.closest('.acf-field, .obras-media-help-anchor') : null;
                if (parent && !parent.contains(e.target)) {
                    popup.hidden = true;
                }
            });

            document.querySelectorAll('.obras-help-trigger').forEach(function(trigger) {
                var parent = trigger.closest('.acf-field, .obras-media-help-anchor');
                if (parent && !parent.contains(e.target)) {
                    trigger.setAttribute('aria-expanded', 'false');
                }
            });
        });
    });
    </script>

    <style>
    .acf-field[data-name="archivo_adjunto"] .acf-label,
    .acf-field[data-name="archivo_documento"] .acf-label,
    .acf-field[data-name="archivo_recurso"] .acf-label,
    .obras-media-help-anchor {
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
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        z-index: 1000;
        max-width: 460px;
        min-width: 260px;
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
=======
    // Catálogos
    acf_add_local_field_group( array(
        'key' => 'group_catalogo_obras',
        'title' => 'Datos del Catálogo',
        'fields' => array(
            array(
                'key' => 'field_clase_catalogo',
                'label' => 'Clase del contenido',
                'name' => 'clase_catalogo',
                'type' => 'select',
                'choices' => obras_get_catalogo_plano_class_choices(),
                  'allow_null' => 1,
                  'return_format' => 'value',
            ),
            array(
                'key' => 'field_archivo_catalogo',
                'label' => 'Adjuntar archivo',
                'name' => 'archivo_catalogo',
                'type' => 'file',
                'return_format' => 'array',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'catalogo_obra',
                ),
            ),
        ),
        'position' => 'normal',
        'label_placement' => 'top',
    ) );

    // Planos
    acf_add_local_field_group( array(
        'key' => 'group_plano_obras',
        'title' => 'Datos del Plano',
        'fields' => array(
            array(
                'key' => 'field_clase_plano',
                'label' => 'Clase del contenido',
                'name' => 'clase_plano',
                'type' => 'select',
                'choices' => obras_get_catalogo_plano_class_choices(),
                  'allow_null' => 1,
                  'return_format' => 'value',
            ),
            array(
                'key' => 'field_archivo_plano',
                'label' => 'Adjuntar archivo',
                'name' => 'archivo_plano',
                'type' => 'file',
                'return_format' => 'array',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'plano_obra',
                ),
            ),
        ),
        'position' => 'normal',
        'label_placement' => 'top',
    ) );

    endif;


    // ============================================================================
    // === AYUDA CONTEXTUAL EN CAMPOS ACF DE ARCHIVO ==============================
    // ============================================================================

    add_action( 'admin_footer', 'obras_acf_file_field_help_tooltips' );
    function obras_acf_file_field_help_tooltips() {
        if ( ! is_admin() ) {
            return;
        }

        $screen = get_current_screen();
        if ( ! $screen ) {
            return;
        }

        if ( 'post' !== $screen->base ) {
            return;
        }

        $allowed_post_types = array(
            'bitacora',
            'documento_obra',
            'material_obra',
            'catalogo_obra',
            'plano_obra',
        );

        if ( ! in_array( $screen->post_type, $allowed_post_types, true ) ) {
            return;
        }

        $file_help_map = array(
            'archivo_adjunto'   => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
            'archivo_documento' => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
            'archivo_recurso'   => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
            'archivo_catalogo'  => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
            'archivo_plano'     => 'Adjunta un archivo a esta publicación. No se inserta dentro del texto: quedará disponible como archivo adjunto al final.',
        );

        $media_help = 'Usa “Añadir medios” para insertar una foto o imagen dentro del texto. Usa “Adjuntar archivo” para dejar un archivo asociado a la publicación.';
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fileHelpMap = <?php echo wp_json_encode( $file_help_map ); ?>;
            var mediaHelp   = <?php echo wp_json_encode( $media_help ); ?>;

            function closeAllHelps(exceptPopup, exceptTrigger) {
                document.querySelectorAll('.obras-help-popup').forEach(function(otherPopup) {
                    if (otherPopup !== exceptPopup) {
                        otherPopup.hidden = true;
                    }
                });

                document.querySelectorAll('.obras-help-trigger').forEach(function(otherTrigger) {
                    if (otherTrigger !== exceptTrigger) {
                        otherTrigger.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            function buildHelpTrigger(text) {
                var trigger = document.createElement('button');
                trigger.type = 'button';
        trigger.className = 'obras-help-trigger';
        trigger.setAttribute('aria-expanded', 'false');
        trigger.setAttribute('title', 'Ayuda');
        trigger.textContent = '?';

        var popup = document.createElement('div');
        popup.className = 'obras-help-popup';
        popup.hidden = true;
        popup.innerHTML = text;

        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var isHidden = popup.hidden;
            closeAllHelps(popup, trigger);
            popup.hidden = !isHidden;
            trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });

        return { trigger: trigger, popup: popup };
            }

            Object.keys(fileHelpMap).forEach(function(fieldName) {
                var field = document.querySelector('.acf-field[data-name="' + fieldName + '"]');
                if (!field) {
                    return;
                }

                var label = field.querySelector('.acf-label label');
                var labelWrap = field.querySelector('.acf-label');

                if (!label || !labelWrap) {
                    return;
                }

                if (field.querySelector('.obras-help-trigger')) {
                    return;
                }

                var help = buildHelpTrigger(fileHelpMap[fieldName]);

                label.style.display = 'inline-flex';
            label.style.alignItems = 'center';
            label.style.gap = '8px';

            label.appendChild(help.trigger);
            labelWrap.appendChild(help.popup);
            });

            var mediaButton = document.querySelector('.wp-media-buttons .insert-media');
            var mediaWrap   = document.querySelector('.wp-media-buttons');

            if (mediaButton && mediaWrap && !mediaWrap.querySelector('.obras-media-help-anchor')) {
                var anchor = document.createElement('span');
                anchor.className = 'obras-media-help-anchor';
        anchor.style.position = 'relative';
        anchor.style.display = 'inline-flex';
        anchor.style.alignItems = 'center';
        anchor.style.marginLeft = '8px';

        var mediaHelpParts = buildHelpTrigger(mediaHelp);

        anchor.appendChild(mediaHelpParts.trigger);
        anchor.appendChild(mediaHelpParts.popup);
        mediaWrap.appendChild(anchor);
            }

            document.addEventListener('click', function(e) {
                document.querySelectorAll('.obras-help-popup').forEach(function(popup) {
                    var parent = popup.parentElement ? popup.parentElement.closest('.acf-field, .obras-media-help-anchor') : null;
                    if (parent && !parent.contains(e.target)) {
                        popup.hidden = true;
                    }
                });

                document.querySelectorAll('.obras-help-trigger').forEach(function(trigger) {
                    var parent = trigger.closest('.acf-field, .obras-media-help-anchor');
                    if (parent && !parent.contains(e.target)) {
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        });
        </script>

        <style>
        .acf-field[data-name="archivo_adjunto"] .acf-label,
        .acf-field[data-name="archivo_documento"] .acf-label,
        .acf-field[data-name="archivo_recurso"] .acf-label,
        .acf-field[data-name="archivo_catalogo"] .acf-label,
        .acf-field[data-name="archivo_plano"] .acf-label,
        .obras-media-help-anchor {
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
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            z-index: 1000;
            max-width: 460px;
            min-width: 260px;
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
>>>>>>> Stashed changes
