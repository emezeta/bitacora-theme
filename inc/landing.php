<?php
/**
 * Bitácora de Obra - Landing Page.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
            <!-- BOTÓN 6 - ALIENÍGENA (PÚRPURA)  #9b59b6  -->
            <div class="obras-feature obras-feature-alien">
                <span class="icon">🛸</span>
                <h3>Placeholder</h3>
                <p>Botón temporal - modificar landing.php +66</p>
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
