<?php
/**
 * Bitácora de Obra - CPT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// "Bitácora"
function obras_register_bitacora_cpt() {
    register_post_type( 'bitacora', array(
        'labels' => array(
            'name'                  => 'Notas',
            'singular_name'         => 'Nota',
            'menu_name'             => 'Bitácora',
            'name_admin_bar'        => 'Nota',
            'add_new'               => 'Nueva nota',
            'add_new_item'          => 'Agrega nota nueva',
            'new_item'              => 'Nueva nota',
            'edit_item'             => 'Editar nota',
            'view_item'             => 'Ver nota',
            'all_items'             => 'Notas',
            'search_items'          => 'Buscar notas',
            'not_found'             => 'No se encontraron notas',
            'not_found_in_trash'    => 'No se encontraron notas en la papelera',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'bitacora-cpt' ),
        'supports' => array( 'title', 'editor', 'author' ),
        'menu_icon' => 'dashicons-book',
        'menu_position' => 2,
        'show_in_rest' => false,
    ));
}

// "Documentos"
function obras_register_documento_cpt() {
    register_post_type( 'documento_obra', array(
        'labels' => array(
            'name' => 'Documentos',
            'singular_name' => 'Documento',
            'add_new' => 'Nuevo Documento',
            'menu_name' => 'Documentos',
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array( 'slug' => 'documentos-cpt' ),
        'supports' => array( 'title', 'editor', 'author' ),
        'menu_icon' => 'dashicons-media-document',
        'menu_position' => 3,
        'show_in_rest' => false,
        'show_in_menu' => 'edit.php?post_type=bitacora',
    ));
}

// "Materiales"
function obras_register_material_cpt() {
    register_post_type( 'material_obra', array(
        'labels' => array(
            'name' => 'Materiales',
            'singular_name' => 'Material',
            'add_new' => 'Nuevo Material',
            'menu_name' => 'Materiales',
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array( 'slug' => 'materiales-cpt' ),
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon' => 'dashicons-archive',
        'menu_position' => 4,
        'show_in_rest' => false,
        'show_in_menu' => 'edit.php?post_type=bitacora',
    ));
}

// Hooks
add_action( 'init', 'obras_register_bitacora_cpt' );
add_action( 'init', 'obras_register_documento_cpt' );
add_action( 'init', 'obras_register_material_cpt' );

// ============================================================================
// === ADMIN: COLUMNA TIPO DE MATERIAL ========================================
// ============================================================================

// Agregar columna
add_filter( 'manage_material_obra_posts_columns', 'obras_add_tipo_material_column' );
function obras_add_tipo_material_column( $columns ) {

    $new = array();

    foreach ( $columns as $key => $label ) {
        $new[ $key ] = $label;

        if ( $key === 'title' ) {
            $new['tipo_material'] = 'Tipo de material';
        }
    }

    return $new;
}

// Mostrar contenido de la columna
add_action( 'manage_material_obra_posts_custom_column', 'obras_render_tipo_material_column', 10, 2 );
function obras_render_tipo_material_column( $column, $post_id ) {

    if ( $column !== 'tipo_material' ) {
        return;
    }

    $tipo = get_post_meta( $post_id, 'tipo_material', true );

    if ( ! $tipo ) {
        echo '<span style="color:#999;">—</span>';
        return;
    }

    // Formateo simple (capitalizar)
    echo esc_html( ucfirst( $tipo ) );
}

// Hacerla sortable (opcional pero útil)
add_filter( 'manage_edit-material_obra_sortable_columns', function( $columns ) {
    $columns['tipo_material'] = 'tipo_material';
    return $columns;
});
