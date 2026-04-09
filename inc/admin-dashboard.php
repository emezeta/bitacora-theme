<?php
/*
 * Bitácora de Obra - Dashboard Admin Personalizado
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


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
