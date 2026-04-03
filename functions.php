<?php
/**
 * Bitácora de Obra - Child Theme Functions
 * Parent: Twenty Twenty-Five
 * Version: 1.1.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ============================================================================
// === ENQUEUE: PARENT + CHILD STYLES (DIVIDIDOS) =============================
// ============================================================================
add_action( 'wp_enqueue_scripts', 'obras_enqueue_styles', 10 );
function obras_enqueue_styles() {
    // Parent theme stylesheet
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
                     array(),
                     wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
    );

    // Child theme stylesheet
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
                     array( 'parent-style' ),
                     wp_get_theme()->get( 'Version' )
    );

    // Custom consolidated CSS (parte común)
    wp_enqueue_style(
        'obras-custom',
        get_stylesheet_directory_uri() . '/css/custom.css',
                     array( 'child-style' ),
                     '2.0.0'
    );

    // Landing Page CSS (solo en home)
    if ( is_front_page() ) {
        wp_enqueue_style(
            'obras-land',
            get_stylesheet_directory_uri() . '/css/landpage.css',
                         array( 'obras-custom' ),
                         '2.0.0'
        );
    }

    // Dashboard Frontend CSS (solo logueados)
    if ( is_user_logged_in() ) {
        wp_enqueue_style(
            'obras-dashboardfe',
            get_stylesheet_directory_uri() . '/css/dashboardfe.css',
                         array( 'obras-custom' ),
                         '2.0.0'
        );
    }
}




// ============================================================================
// === DESACTIVAR GUTENBERG / FORZAR CLASSIC EDITOR ===========================
// ============================================================================

add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
add_filter( 'use_block_editor_for_post', '__return_false', 100 );
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
remove_theme_support( 'core-block-patterns' );
remove_theme_support( 'block-templates' );

add_filter( 'classic_editor_enabled_editors', function( $editors ) {
    return array( 'classic' => true );
} );


// ============================================================================
// === DESACTIVAR GLOBAL STYLES DEL TEMA BLOCK ================================
// ============================================================================

//  // 1. Remover global styles inline
//  add_action( 'wp_enqueue_scripts', function() {
//      wp_dequeue_style( 'global-styles' );
//      wp_deregister_style( 'global-styles' );
//  }, 100 );
//
//  // 2. Remover soporte para block templates (ya lo tenés, pero reforzar)
//  remove_theme_support( 'block-templates' );
//  remove_theme_support( 'core-block-patterns' );
//
//  // 3. Desactivar wp_global_styles
//  add_filter( 'wp_global_styles', '__return_empty_array', 100 );


// ============================================================================
// === CUSTOM POST TYPES (3 entidades base) ===================================
// ============================================================================

// "Entradas" en el interfaz
function obras_register_bitacora_cpt() {
    register_post_type( 'bitacora', array(
        'labels' => array(
            'name' => 'Bitácora',
            'singular_name' => 'Entrada',
            'add_new' => 'Nueva Entrada',
            'menu_name' => 'Bitácora',
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

add_action( 'init', 'obras_register_bitacora_cpt' );
add_action( 'init', 'obras_register_documento_cpt' );
add_action( 'init', 'obras_register_material_cpt' );

// ============================================================================
// === ACF: CAMPOS VÍA CÓDIGO (sin UI) ========================================
// ============================================================================

if ( function_exists( 'acf_add_local_field_group' ) ):

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
    ));

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
    ));

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
    ));

    endif;

    // ============================================================================
    // === KIOSK MODE: SIMPLIFICACIÓN ADMIN =======================================
    // ============================================================================

    add_action( 'admin_menu', 'obras_kiosk_admin_menu', 999 );
    function obras_kiosk_admin_menu() {
        if ( current_user_can( 'manage_options' ) ) {
            return;
        }
        foreach ( array( 'index.php', 'edit.php', 'upload.php', 'edit.php?post_type=page', 'users.php', 'plugins.php', 'themes.php', 'tools.php', 'options-general.php' ) as $page ) {
            remove_menu_page( $page );
        }
    }

    add_action( 'wp_dashboard_setup', 'obras_kiosk_dashboard' );
    function obras_kiosk_dashboard() {
        if ( current_user_can( 'manage_options' ) ) {
            return;
        }
        remove_all_actions( 'wp_dashboard_setup' );
    }

    add_action( 'wp_before_admin_bar_render', 'obras_kiosk_admin_bar' );
    function obras_kiosk_admin_bar() {
        if ( current_user_can( 'manage_options' ) ) {
            return;
        }
        global $wp_admin_bar;
        foreach ( array( 'wp-logo', 'updates', 'comments', 'new-content' ) as $item ) {
            $wp_admin_bar->remove_menu( $item );
        }
    }

    add_filter( 'screen_options_show_screen', 'obras_hide_screen_options' );
    function obras_hide_screen_options( $show ) {
        return current_user_can( 'manage_options' ) ? $show : false;
    }

    // ============================================================================
    // === BLOQUEO WP-ADMIN PARA NO-ADMINS ========================================
    // ============================================================================

    add_action( 'admin_init', 'obras_block_admin_access', 1 );
    function obras_block_admin_access() {
        if ( current_user_can( 'manage_options' ) ) {
            return;
        }
        $allowed = array( 'profile.php', 'user-edit.php' );
        $current = basename( $_SERVER['PHP_SELF'] );
        if ( ! in_array( $current, $allowed ) && ! headers_sent() ) {
            wp_redirect( home_url( '/' ) );
            exit;
        }
    }

    // ============================================================================
    // === DASHBOARD ADMIN PERSONALIZADO ==========================================
    // ============================================================================

    add_action( 'admin_menu', 'obras_add_dashboard_page' );
    function obras_add_dashboard_page() {
        add_submenu_page(
            'edit.php?post_type=bitacora',
            'Inicio',
            'Inicio',
            'read',
            'bitacora-dashboard',
            'obras_render_dashboard'
        );
    }

    function obras_render_dashboard() {
        ?>
        <div class="wrap">
        <h1>Bitácora de Obra</h1>
        <p>¡Hola, <?php echo esc_html( wp_get_current_user()->display_name ); ?>!</p>
        <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:30px;">
        <a href="post-new.php?post_type=bitacora" class="button button-primary button-hero">✍️<br>Nueva Entrada</a>
        <a href="edit.php?post_type=bitacora" class="button button-secondary button-hero">📋<br>Ver Entradas</a>
        <a href="edit.php?post_type=documento_obra" class="button button-secondary button-hero">📄<br>Documentos</a>
        <a href="edit.php?post_type=material_obra" class="button button-secondary button-hero">🧰<br>Materiales</a>
        </div>
        </div>
        <?php
    }

    // ============================================================================
    // === RESTRICCIÓN POR USUARIO (PÁGINAS) ======================================
    // ============================================================================

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
                if ( ! is_user_logged_in() || ! in_array( get_current_user_id(), $allowed ) ) {
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
                    if ( ! is_user_logged_in() || ! in_array( get_current_user_id(), $allowed ) ) {
                        unset( $items[ $key ] );
                    }
                }
            }
        }
        return $items;
    }

    // ============================================================================
    // === REDIRECCIONES LOGIN/LOGOUT =============================================
    // ============================================================================

    add_filter( 'show_admin_bar', function( $show ) {
        return current_user_can( 'manage_options' ) ? $show : false;
    } );

    add_filter( 'login_redirect', 'obras_frontend_login_redirect', 10, 3 );
    function obras_frontend_login_redirect( $redirect_to, $request, $user ) {
        if ( current_user_can( 'manage_options' ) ) {
            return admin_url();
        }
        return home_url( '/' );
    }

    add_filter( 'logout_redirect', 'obras_logout_redirect_frontend', 10, 3 );
    function obras_logout_redirect_frontend( $redirect_to, $requested_redirect_to, $user ) {
        return home_url( '/' );
    }

    // ============================================================================
    // === SHORTCODES FRONTEND ====================================================
    // ============================================================================

    // [obras_dashboard]
    add_shortcode( 'obras_dashboard', 'obras_render_dashboard_frontend' );
    function obras_render_dashboard_frontend() {
        if ( ! is_user_logged_in() ) {
            return '<p>Debes <a href="' . wp_login_url( get_permalink() ) . '">iniciar sesión</a> para ver el contenido.</p>';
        }
        $user = wp_get_current_user();

        ob_start();
        ?>

        <div class="obras-dashboard">

        <h1>Bitácora de Obra</h1>
        <p class="welcome">¡Hola, <?php echo esc_html( $user->display_name ); ?>!</p>
        <p>¿Qué querés hacer hoy?</p>
        <div class="obras-buttons">
        <a href="<?php echo admin_url( 'post-new.php?post_type=bitacora' ); ?>" class="obras-button">
        <span class="icon">✍️</span>
        Nueva Entrada
        </a>
        <a href="<?php echo home_url( '/entradas/' ); ?>" class="obras-button secondary">
        <span class="icon">📋</span>
        Ver Entradas
        </a>
        <a href="<?php echo home_url( '/documentos/' ); ?>" class="obras-button secondary">
        <span class="icon">📄</span>
        Documentos
        </a>
        <a href="<?php echo home_url( '/materiales/' ); ?>" class="obras-button secondary">
        <span class="icon">🧰</span>
        Materiales
        </a>
        <a href="<?php echo home_url( '/catalogos/' ); ?>" class="obras-button secondary">
        <span class="icon">📚</span>
        Catálogos
        </a>
        <a href="<?php echo home_url( '/planos/' ); ?>" class="obras-button secondary">
        <span class="icon">📐</span>
        Planos
        </a>
        </div>
        </div>
        <?php
        return ob_get_clean();
    }

    // [obras_lista_entradas]
    add_shortcode( 'obras_lista_entradas', 'obras_render_lista_entradas' );
    function obras_render_lista_entradas() {
        if ( ! is_user_logged_in() ) {
            return '<p>Debes <a href="' . wp_login_url( get_permalink() ) . '">iniciar sesión</a> para ver el contenido.</p>';
        }
        $query = new WP_Query( array(
            'post_type' => 'bitacora',
            'posts_per_page' => 20,
            'orderby' => 'date',
            'order' => 'DESC',
        ) );
        ob_start();
        ?>
        <div class="obras-lista">
        <h1>📋 Entradas de Bitácora</h1>
        <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="item">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="meta">
        <span class="fecha">📅 <?php echo get_post_meta( get_the_ID(), 'fecha_obra', true ) ?: get_the_date( 'd/m/Y' ); ?></span>
        <span class="author">✍️ <?php echo get_the_author(); ?></span>
        </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
        <p class="empty">Aún no hay entradas. ¡Sé el primero en crear una!</p>
        <?php endif; ?>
        <a href="<?php echo home_url( '/' ); ?>" class="back-link">← Volver al inicio</a>
        </div>
        <?php
        return ob_get_clean();
    }

    // [obras_lista_documentos]
    add_shortcode( 'obras_lista_documentos', 'obras_render_lista_documentos' );
    function obras_render_lista_documentos() {
        if ( ! is_user_logged_in() ) {
            return '<p>Debes <a href="' . wp_login_url( get_permalink() ) . '">iniciar sesión</a> para ver el contenido.</p>';
        }
        $query = new WP_Query( array(
            'post_type' => 'documento_obra',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
        ) );
        ob_start();
        ?>
        <div class="obras-lista">
        <h1>📄 Documentos de Obra</h1>
        <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="item">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <span class="tipo"><?php echo get_post_meta( get_the_ID(), 'tipo_documento', true ) ?: 'Documento'; ?></span>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
        <p class="empty">Aún no hay documentos.</p>
        <?php endif; ?>
        <a href="<?php echo home_url( '/' ); ?>" class="back-link">← Volver al inicio</a>
        </div>
        <?php
        return ob_get_clean();
    }

    // [obras_lista_materiales]
    add_shortcode( 'obras_lista_materiales', 'obras_render_lista_materiales' );
    function obras_render_lista_materiales() {
        if ( ! is_user_logged_in() ) {
            return '<p>Debes <a href="' . wp_login_url( get_permalink() ) . '">iniciar sesión</a> para ver el contenido.</p>';
        }
        $query = new WP_Query( array(
            'post_type' => 'material_obra',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
        ) );
        ob_start();
        ?>
        <div class="obras-lista">
        <h1>🧰 Materiales y Recursos</h1>
        <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="item">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <span class="tipo"><?php echo get_post_meta( get_the_ID(), 'tipo_material', true ) ?: 'Material'; ?></span>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
        <p class="empty">Aún no hay materiales registrados.</p>
        <?php endif; ?>
        <a href="<?php echo home_url( '/' ); ?>" class="back-link">← Volver al inicio</a>
        </div>
        <?php
        return ob_get_clean();
    }

    // [obras_lista_catalogos]
    add_shortcode( 'obras_lista_catalogos', 'obras_render_lista_catalogos' );
    function obras_render_lista_catalogos() {
        if ( ! is_user_logged_in() ) {
            return '<p>Debes <a href="' . wp_login_url( get_permalink() ) . '">iniciar sesión</a> para ver el contenido.</p>';
        }
        $query = new WP_Query( array(
            'post_type' => 'material_obra',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'tipo_material',
                    'value' => 'catalogo',
                    'compare' => '=',
                ),
            ),
        ) );
        ob_start();
        ?>
        <div class="obras-lista">
        <h1>📚 Catálogos de Materiales</h1>
        <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="item">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <span class="tipo"><?php echo get_post_meta( get_the_ID(), 'tipo_material', true ) ?: 'Catálogo'; ?></span>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
        <p class="empty">Aún no hay catálogos registrados.</p>
        <?php endif; ?>
        <a href="<?php echo home_url( '/' ); ?>" class="back-link">← Volver al inicio</a>
        </div>
        <?php
        return ob_get_clean();
    }

    // [obras_lista_planos]
    add_shortcode( 'obras_lista_planos', 'obras_render_lista_planos' );
    function obras_render_lista_planos() {
        if ( ! is_user_logged_in() ) {
            return '<p>Debes <a href="' . wp_login_url( get_permalink() ) . '">iniciar sesión</a> para ver el contenido.</p>';
        }
        $query = new WP_Query( array(
            'post_type' => 'material_obra',
            'posts_per_page' => 50,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'tipo_material',
                    'value' => 'plano',
                    'compare' => '=',
                ),
            ),
        ) );
        ob_start();
        ?>
        <div class="obras-lista">
        <h1>📐 Planos de Obra</h1>
        <?php if ( $query->have_posts() ) : ?>
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="item">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <span class="tipo"><?php echo get_post_meta( get_the_ID(), 'tipo_material', true ) ?: 'Plano'; ?></span>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
        <p class="empty">Aún no hay planos registrados.</p>
        <?php endif; ?>
        <a href="<?php echo home_url( '/' ); ?>" class="back-link">← Volver al inicio</a>
        </div>
        <?php
        return ob_get_clean();
    }

    // [obras_menu_logout]
    add_shortcode( 'obras_menu_logout', 'obras_render_menu_logout' );
    function obras_render_menu_logout() {
        if ( ! is_user_logged_in() ) {
            return '<a href="' . wp_login_url( get_permalink() ) . '" class="obras-login-link">Iniciar sesión</a>';
        }
        $user = wp_get_current_user();
        ob_start();
        ?>
        <div class="obras-user-menu">
        <div class="obras-user-info" onclick="document.querySelector('.obras-dropdown').classList.toggle('show')">
        👤 <?php echo esc_html( $user->display_name ); ?>
        <span style="font-size: 0.8em;">▼</span>
        </div>
        <div class="obras-dropdown">
        <a href="<?php echo admin_url( 'profile.php' ); ?>">Mi Perfil</a>
        <a href="<?php echo wp_logout_url( home_url( '/' ) ); ?>" class="logout">Cerrar sesión</a>
        </div>
        </div>
        <script>
        document.addEventListener('click', function(event) {
            var menu = document.querySelector('.obras-user-menu');
            var dropdown = document.querySelector('.obras-dropdown');
            if (!menu.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
        </script>
        <?php
        return ob_get_clean();
    }

    add_action( 'wp_footer', 'obras_add_logout_menu_to_frontend' );
    function obras_add_logout_menu_to_frontend() {
        if ( is_user_logged_in() && ! current_user_can( 'manage_options' ) ) {
            echo do_shortcode( '[obras_menu_logout]' );
        }
    }

    // ============================================================================
    // === MOSTRAR CAMPOS ACF EN SINGLE POST ======================================
    // ============================================================================

    add_action( 'the_content', 'obras_display_acf_fields_on_single' );
    function obras_display_acf_fields_on_single( $content ) {
        if ( is_admin() || ! is_single() ) {
            return $content;
        }

        $post_type = get_post_type();
        $post_id = get_the_ID();
        $html = '';

        // Bitácora
        if ( $post_type === 'bitacora' ) {
            $fecha_raw = get_post_meta( $post_id, 'fecha_obra', true );
            $archivo_id = get_post_meta( $post_id, 'archivo_adjunto', true );

            $html .= '<div class="obras-acf-box bitacora">';
            $html .= '<h3>📋 Datos de la Entrada</h3>';

            if ( ! empty( $fecha_raw ) ) {
                $fecha_formateada = date_i18n( get_option( 'date_format' ), strtotime( $fecha_raw ) );
                $html .= '<p><strong>📅 Fecha:</strong> ' . esc_html( $fecha_formateada ) . '</p>';
            } else {
                $html .= '<p><em>⚠️ Sin fecha registrada</em></p>';
            }

            if ( ! empty( $archivo_id ) ) {
                if ( is_numeric( $archivo_id ) ) {
                    $archivo_url = wp_get_attachment_url( $archivo_id );
                    $archivo_filename = get_post_meta( $archivo_id, '_wp_attachment_image_alt', true ) ?: basename( $archivo_url );
                    $html .= '<p><strong>📎 Archivo adjunto:</strong> <a href="' . esc_url( $archivo_url ) . '" target="_blank">' . esc_html( $archivo_filename ) . '</a></p>';
                } elseif ( is_array( $archivo_id ) && isset( $archivo_id['url'] ) ) {
                    $html .= '<p><strong>📎 Archivo adjunto:</strong> <a href="' . esc_url( $archivo_id['url'] ) . '" target="_blank">' . esc_html( $archivo_id['filename'] ?? basename( $archivo_id['url'] ) ) . '</a></p>';
                }
            } else {
                $html .= '<p><em>⚠️ Sin archivo adjunto</em></p>';
            }
            $html .= '</div>';
        }

        // Documentos
        if ( $post_type === 'documento_obra' ) {
            $tipo = get_post_meta( $post_id, 'tipo_documento', true );
            $archivo_id = get_post_meta( $post_id, 'archivo_documento', true );

            $html .= '<div class="obras-acf-box documento">';
            $html .= '<h3>📄 Datos del Documento</h3>';

            if ( ! empty( $tipo ) ) {
                $html .= '<p><strong>Tipo:</strong> ' . esc_html( $tipo ) . '</p>';
            }

            if ( ! empty( $archivo_id ) && is_numeric( $archivo_id ) ) {
                $archivo_url = wp_get_attachment_url( $archivo_id );
                $html .= '<p><strong>📎 Archivo:</strong> <a href="' . esc_url( $archivo_url ) . '" target="_blank">' . basename( $archivo_url ) . '</a></p>';
            }
            $html .= '</div>';
        }

        // Materiales
        if ( $post_type === 'material_obra' ) {
            $tipo = get_post_meta( $post_id, 'tipo_material', true );
            $archivo_id = get_post_meta( $post_id, 'archivo_recurso', true );
            $ubicacion = get_post_meta( $post_id, 'ubicacion_fisica', true );

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
                $html .= '<p><strong>📎 Archivo:</strong> <a href="' . esc_url( $archivo_url ) . '" target="_blank">' . basename( $archivo_url ) . '</a></p>';
            }
            $html .= '</div>';
        }

        return $content . $html;
    }

    // ============================================================================
    // === PERSONALIZAR LOGIN/REGISTER (HOOKS CON FIX DEPRECATED) =================
    // ============================================================================

    add_action( 'login_enqueue_scripts', 'obras_custom_login_assets' );
    function obras_custom_login_assets() {
        $logo = get_stylesheet_directory_uri() . '/images/login_obras.png';
        if ( ! file_exists( get_stylesheet_directory() . '/images/login_obras.png' ) ) {
            $logo = 'https://obras.angiru.uy/wp-content/uploads/2026/03/login_obras.png';
        }

        add_filter( 'login_headerurl', function() {
            return home_url( '/' );
        } );

        // ✅ FIX: login_headertitle → login_headertext (WordPress 5.2+)
        add_filter( 'login_headertext', function() {
            return get_bloginfo( 'name' ) . ' - Acceso a Bitácora';
        } );

        add_action( 'login_footer', function() {
            echo '<div style="text-align:center; margin-top:30px; color:#666; font-size:12px;"><p>Bitácora de Obra - Obras Angirü</p></div>';
        } );
    }

    add_action( 'register_enqueue_scripts', 'obras_custom_register_assets' );
    function obras_custom_register_assets() {
        $logo = get_stylesheet_directory_uri() . '/images/login_obras.png';
        if ( ! file_exists( get_stylesheet_directory() . '/images/login_obras.png' ) ) {
            $logo = 'https://obras.angiru.uy/wp-content/uploads/2026/03/login_obras.png';
        }

        add_filter( 'register_headerurl', function() {
            return home_url( '/' );
        } );

        // ✅ FIX: register_headertitle → register_headertext (WordPress 5.2+)
        add_filter( 'register_headertext', function() {
            return get_bloginfo( 'name' ) . ' - Registro';
        } );

        add_action( 'register_footer', function() {
            echo '<div style="text-align:center; margin-top:30px; color:#666; font-size:12px;"><p>Bitácora de Obra - Obras Angirü</p></div>';
        } );
    }

    add_filter( 'admin_footer_text', function() {
        return 'Gracias por usar <strong>Bitácora de Obra - Angirü</strong> | <a href="' . admin_url( 'profile.php' ) . '">Mi Perfil</a>';
    } );

    // ============================================================================
    // === LANDING PAGE PARA NO-LOGUEADOS =========================================
    // ============================================================================

    add_shortcode( 'obras_landing_page', 'obras_render_landing_page' );
    function obras_render_landing_page() {
        if ( is_user_logged_in() ) {
            return do_shortcode( '[obras_dashboard]' );
        }

        $logo = get_stylesheet_directory_uri() . '/images/login_obras.png';
        if ( ! file_exists( get_stylesheet_directory() . '/images/login_obras.png' ) ) {
            $logo = 'https://obras.angiru.uy/wp-content/uploads/2026/03/login_obras.png';
        }
        ob_start();
        ?>
        <div class="obras-landing">
            <div class="obras-landing-logo">
                <img src="<?php echo esc_url( $logo ); ?>" alt="Obras Angirü">
            </div>
            <h1>Bitácora de Obra</h1>
            <p class="subtitle">Gestión simplificada de proyectos en construcción.<br>Documentación, materiales y seguimiento en un solo lugar.</p>
            <div class="obras-landing-buttons">
                <a href="<?php echo wp_login_url(); ?>" class="obras-landing-btn login">🔐 Acceder</a>
                <a href="<?php echo wp_registration_url(); ?>" class="obras-landing-btn register">📝 Registrarse</a>
            </div>
            <div class="obras-landing-features">
                <div class="obras-feature">
                    <span class="icon">✍️</span>
                    <h3>Entradas Rápidas</h3>
                    <p>Registra actividades y novedades de obra en minutos</p>
                </div>
                <div class="obras-feature">
                    <span class="icon">📄</span>
                    <h3>Documentos</h3>
                    <p>Accedé a planos, notas e instructivos cuando los necesites</p>
                </div>
                <div class="obras-feature">
                    <span class="icon">🧰</span>
                    <h3>Materiales</h3>
                    <p>Seguimiento de recursos y ubicación en la obra</p>
                </div>
                <div class="obras-feature">
                    <span class="icon">📚</span>
                    <h3>Catálogos</h3>
                    <p>Consultá catálogos de productos y materiales</p>
                </div>
                <div class="obras-feature">
                    <span class="icon">📐</span>
                    <h3>Planos</h3>
                    <p>Visualizá planos en PDF e imágenes de la obra</p>
                </div>

                <!-- =================================================================
                BOTÓN 6 - ALIENÍGENA (FÁCIL IDENTIFICACIÓN PARA MODIFICACIÓN)
                Texto: "Cambiar texto aquí"
                Ícono: 🛸 (diferente a todos los demás)
                Color: #9b59b6 (púrpura - diferente al azul #2271b1 del tema)
                ================================================================= -->

                <div class="obras-feature obras-feature-alien">
                    <span class="icon">🛸</span>
                    <h3>Cambiar texto aquí</h3>
                    <p>Este botón es temporal - modificar en functions.php</p>
                </div>
            </div>
            <div class="obras-landing-footer">
                <p>🏗️ Obras Angirü - Gestión de proyectos en construcción</p>
                <p style="margin-top:10px; font-size:1em;">Acceso exclusivo para miembros del proyecto</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    add_filter( 'the_content', 'obras_landing_content_filter' );
    function obras_landing_content_filter( $content ) {
        if ( is_front_page() && ! is_user_logged_in() ) {
            return do_shortcode( '[obras_landing_page]' );
        }
        return $content;
    }



    // ============================================================================
    // === FORZAR TEMPLATE PARA LISTADOS FRONTEND =================================
    // ============================================================================

    add_filter( 'template_include', 'obras_force_page_template_for_listados', 999 );
    function obras_force_page_template_for_listados( $template ) {
        if ( is_admin() ) {
            return $template;
        }

        $slugs = array( 'documentos', 'materiales', 'entradas' );
        $slug = get_query_var( 'name' );

        if ( in_array( $slug, $slugs, true ) ) {
            $page = get_page_by_path( $slug );
            if ( $page && $page->post_status === 'publish' && $page->post_type === 'page' ) {
                $t = locate_template( 'page.php' );
                if ( $t ) {
                    return $t;
                }
            }
        }

        return $template;
    }

    // Truffita va a dormir!! (child completo v1.1.1) 🐕✨

    /*
     *
     o *b_start();
     ?>
     <h1 style="color:red; font-size:40px;">
     DEBUG DASHBOARD FRONTEND
     </h1>
     <?php
     return ob_get_clean();
     }
     */
