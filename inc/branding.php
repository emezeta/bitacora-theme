<?php
/**
 * Bitácora de Obra - Personalización Login/Register
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
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
