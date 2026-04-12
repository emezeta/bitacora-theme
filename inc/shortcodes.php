<?php
/**
 * Bitácora de Obra - Shortcodes Frontend.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ============================================================================
// === SHORTCODES FRONTEND ====================================================
// ============================================================================

/**
 * Barra simple de acciones para listados frontend.
 */
function obras_render_lista_actions( $new_url, $new_label ) {
    ?>
    <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center; margin:0 0 25px;">
    <a href="<?php echo esc_url( $new_url ); ?>"
    style="display:inline-block; padding:12px 20px; background:#2271b1; color:#fff; text-decoration:none; border-radius:8px; font-weight:600;">
    <?php echo esc_html( $new_label ); ?>
    </a>

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
    style="display:inline-block; padding:12px 20px; background:#6c757d; color:#fff; text-decoration:none; border-radius:8px; font-weight:600;">
    Volver al inicio
    </a>
    </div>
    <?php
}


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
    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=bitacora' ) ); ?>" class="obras-button">
    <span class="icon">✍️</span>
    Nueva Nota
    </a>

    <a href="<?php echo esc_url( home_url( '/entradas/' ) ); ?>" class="obras-button secondary">
    <span class="icon">📋</span>
    Ver Notas
    </a>

    <a href="<?php echo esc_url( home_url( '/documentos/' ) ); ?>" class="obras-button secondary">
    <span class="icon">📄</span>
    Documentos
    </a>

    <a href="<?php echo esc_url( home_url( '/materiales/' ) ); ?>" class="obras-button secondary">
    <span class="icon">🧰</span>
    Materiales
    </a>

    <a href="<?php echo esc_url( home_url( '/catalogos/' ) ); ?>" class="obras-button secondary">
    <span class="icon">📚</span>
    Catálogos
    </a>

    <a href="<?php echo esc_url( home_url( '/planos/' ) ); ?>" class="obras-button secondary">
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
        'post_type'      => 'bitacora',
        'posts_per_page' => 20,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    ob_start();
    ?>
    <div class="obras-lista">
    <h1>📋 Notas de Bitácora</h1>

    <?php obras_render_lista_actions( admin_url( 'post-new.php?post_type=bitacora' ), '✍️ Nueva nota' ); ?>

    <?php if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="item">
    <h3>
    <a href="<?php the_permalink(); ?>">
    <?php echo esc_html( get_the_title() ?: 'Nota sin título' ); ?>
    </a>
    </h3>

    <div class="meta">
    <span class="fecha">📅 <?php echo esc_html( get_post_meta( get_the_ID(), 'fecha_obra', true ) ?: get_the_date( 'd/m/Y' ) ); ?></span>
    <span class="author">✍️ <?php echo esc_html( get_the_author() ); ?></span>
    </div>

    <?php if ( get_current_user_id() === (int) get_post_field( 'post_author', get_the_ID() ) ) : ?>
    <div style="margin-top:10px;">
    <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"
    style="font-size:0.9em; color:#2271b1; text-decoration:none;">
    ✏️ Editar
    </a>
    </div>
    <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="empty">Aún no hay notas. ¡Sé el primero en crear una!</p>
    <?php endif; ?>
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
        'post_type'      => 'documento_obra',
        'posts_per_page' => 50,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    ob_start();
    ?>
    <div class="obras-lista">
    <h1>📄 Documentos de Obra</h1>

    <?php obras_render_lista_actions( admin_url( 'post-new.php?post_type=documento_obra' ), '📄 Nuevo documento' ); ?>

    <?php if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="item">
    <h3>
    <a href="<?php the_permalink(); ?>">
    <?php echo esc_html( get_the_title() ?: 'Documento sin título' ); ?>
    </a>
    </h3>

    <span class="tipo"><?php echo esc_html( get_post_meta( get_the_ID(), 'tipo_documento', true ) ?: 'Documento' ); ?></span>

    <?php if ( get_current_user_id() === (int) get_post_field( 'post_author', get_the_ID() ) ) : ?>
    <div style="margin-top:10px;">
    <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"
    style="font-size:0.9em; color:#2271b1; text-decoration:none;">
    ✏️ Editar
    </a>
    </div>
    <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="empty">Aún no hay documentos.</p>
    <?php endif; ?>
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
        'post_type'      => 'material_obra',
        'posts_per_page' => 50,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    ob_start();
    ?>
    <div class="obras-lista">
    <h1>🧰 Materiales y Recursos</h1>

    <?php obras_render_lista_actions( admin_url( 'post-new.php?post_type=material_obra' ), '🧰 Nuevo material' ); ?>

    <?php if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="item">
    <h3>
    <a href="<?php the_permalink(); ?>">
    <?php echo esc_html( get_the_title() ?: 'Material sin título' ); ?>
    </a>
    </h3>

    <span class="tipo"><?php echo esc_html( get_post_meta( get_the_ID(), 'tipo_material', true ) ?: 'Material' ); ?></span>

    <?php if ( get_current_user_id() === (int) get_post_field( 'post_author', get_the_ID() ) ) : ?>
    <div style="margin-top:10px;">
    <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"
    style="font-size:0.9em; color:#2271b1; text-decoration:none;">
    ✏️ Editar
    </a>
    </div>
    <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="empty">Aún no hay materiales registrados.</p>
    <?php endif; ?>
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
        'post_type'      => 'material_obra',
        'posts_per_page' => 50,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'tipo_material',
                'value'   => 'catalogo',
                'compare' => '=',
            ),
        ),
    ) );

    ob_start();
    ?>
    <div class="obras-lista">
    <h1>📚 Catálogos de Materiales</h1>

    <?php obras_render_lista_actions( admin_url( 'post-new.php?post_type=material_obra&tipo_material=catalogo' ), '📚 Nuevo catálogo' ); ?>

    <?php if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="item">
    <h3>
    <a href="<?php the_permalink(); ?>">
    <?php echo esc_html( get_the_title() ?: 'Catálogo sin título' ); ?>
    </a>
    </h3>

    <span class="tipo"><?php echo esc_html( get_post_meta( get_the_ID(), 'tipo_material', true ) ?: 'Catálogo' ); ?></span>

    <?php if ( get_current_user_id() === (int) get_post_field( 'post_author', get_the_ID() ) ) : ?>
    <div style="margin-top:10px;">
    <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"
    style="font-size:0.9em; color:#2271b1; text-decoration:none;">
    ✏️ Editar
    </a>
    </div>
    <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="empty">Aún no hay catálogos registrados.</p>
    <?php endif; ?>
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
        'post_type'      => 'material_obra',
        'posts_per_page' => 50,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'tipo_material',
                'value'   => 'plano',
                'compare' => '=',
            ),
        ),
    ) );

    ob_start();
    ?>
    <div class="obras-lista">
    <h1>📐 Planos de Obra</h1>

    <?php obras_render_lista_actions( admin_url( 'post-new.php?post_type=material_obra&tipo_material=plano' ), '📐 Nuevo plano' ); ?>

    <?php if ( $query->have_posts() ) : ?>
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="item">
    <h3>
    <a href="<?php the_permalink(); ?>">
    <?php echo esc_html( get_the_title() ?: 'Plano sin título' ); ?>
    </a>
    </h3>

    <span class="tipo"><?php echo esc_html( get_post_meta( get_the_ID(), 'tipo_material', true ) ?: 'Plano' ); ?></span>

    <?php if ( get_current_user_id() === (int) get_post_field( 'post_author', get_the_ID() ) ) : ?>
    <div style="margin-top:10px;">
    <a href="<?php echo esc_url( get_edit_post_link( get_the_ID() ) ); ?>"
    style="font-size:0.9em; color:#2271b1; text-decoration:none;">
    ✏️ Editar
    </a>
    </div>
    <?php endif; ?>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
    <p class="empty">Aún no hay planos registrados.</p>
    <?php endif; ?>
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
    <a href="<?php echo esc_url( admin_url( 'profile.php' ) ); ?>">Mi Perfil</a>
    <a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="logout">Cerrar sesión</a>
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


// Barra de Menu de Usuario "Mi Perfil/Cerrar"
add_action( 'wp_footer', 'obras_add_logout_menu_to_frontend' );
function obras_add_logout_menu_to_frontend() {
    if ( is_user_logged_in() && ! current_user_can( 'manage_options' ) ) {
        echo do_shortcode( '[obras_menu_logout]' );
    }
}
