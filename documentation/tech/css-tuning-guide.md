# CSS Tuning Guide - Obras Angirü Kiosk WP

Guía paso a paso para ajustar tamaños, espaciados y estilos en todo el sitio

---

## Tabla de Contenidos

    1. Estructura del Archivo
    2. Ajustes por Sección
    3. Valores Recomendados
    4. Cómo Probar Cambios
    5. Backup y Seguridad

---

## Estructura del Archivo `functions.php`

    - Login/Register/Reset Styles (línea 900-1100)
    - Landing Page Styles (línea 1100-1400)
    - Frontend Dashboard Styles (línea 450-500)
    - List Pages Styles (línea 500-650)
    - Single Post ACF Styles (línea 650-800)

---

## Ajustes por Sección

### 1. Landing Page (No Logueado)

Función: `obras_render_landing_page()`

#### Logo
Línea ~1150

```
.obras-landing-logo img {
    max-width: 220px;
    height: auto;
}

Móvil: 180-220px
Tablet: 280px
Desktop: 350px
```

#### Título Principal
Línea ~1160

```
.obras-landing h1 {
    font-size: 1.6em;
}


Móvil: 1.3-1.6em
Tablet: 2em
Desktop: 2.8em
```


#### Subtítulo
Línea ~1170

```
.obras-landing .subtitle {
    font-size: 0.95em;
}

Móvil: 0.9em
Tablet: 1.1em
Desktop: 1.4em
```

#### Botones
Línea ~1190

```
.obras-landing-btn {
    padding: 14px 25px;
    font-size: 1em;
}
```
Desktop override (línea ~1280)

```
@media screen and (min-width: 769px) {
    .obras-landing-btn {
        padding: 22px 55px;
        font-size: 1.35em;
    }
}
```

#### Tarjetas de Características
Línea ~1220

```
.obras-feature {
    padding: 18px 15px;
}
.obras-feature .icon {
    font-size: 2em;
}
.obras-feature h3 {
    font-size: 0.95em;
}
.obras-feature p {
    font-size: 0.8em;
}
```
---

### 2. Login / Register / Password Reset

Funciones: `obras_custom_login_logo()`, `obras_custom_register_style()`

#### Logo

Línea ~920

```
.login h1 a,
.register h1 a {
    width: 350px !important;
    height: 175px !important;
}
```
Responsive móvil (línea ~980)

```
@media screen and (max-width: 480px) {
    .login h1 a {
        width: 280px !important;
        height: 140px !important;
    }
}
```
#### Formulario

Línea ~940

```
.login form,
.register form {
    padding: 25px;
    border-radius: 8px;
}
```

#### Botones
Línea ~950


```
.wp-core-ui .button-primary {
    background: #2271b1 !important;
    padding: 12px 24px;
}
```
---

### 3. Frontend Dashboard (Logueado)

Función: `obras_render_dashboard_frontend()`

#### Contenedor Principal

Línea ~460

```
.obras-dashboard {
    max-width: 800px;
    padding: 20px;
}
```
#### Título y Bienvenida

Línea ~465

```
.obras-dashboard h1 {
    font-size: 2em;
}
.obras-dashboard .welcome {
    font-size: 1.2em;
}
```
#### Botones del Dashboard

Línea ~480

```
    .obras-button {
        padding: 30px 20px;
        font-size: 1.3em;
        border-radius: 8px;
    }
```

Iconos

```
.obras-button .icon {
    font-size: 2em;
    margin-bottom: 10px;
}
```
---

### 4. Páginas de Listado

Funciones: `obras_render_lista_entradas()`, etc.

#### Contenedor de Lista

Línea ~540

```
.obras-lista {
    max-width: 900px;
    padding: 20px;
}
```

#### Items de Lista

Línea ~545


```
.obras-lista .item {
    padding: 15px 20px;
    border-left: 4px solid #2271b1;
}
.obras-lista .item h3 {
    font-size: 1.1em;
}
.obras-lista .item .meta {
    font-size: 0.9em;
}
```
---

### 5. Single Post con Campos ACF

Función:  `obras_display_acf_fields_on_single()`*

#### Caja de Datos ACF

Línea ~700

Estilo inline en PHP, pero puedes extraerlo a CSS:

```
    div[style*="border-left: 4px solid #2271b1"] {
        padding: 20px;
        margin-top: 30px;
    }
```

---

## Valores Recomendados por Dispositivo

Elemento              | Móvil (<480px)  | Tablet (481-768px) | Desktop (>769px)
---------------------|-----------------|-------------------|------------------
Logo Landing         | 180-220px       | 280px             | 350px
Logo Login           | 280x140px       | 350x175px         | 350x175px
H1 Principal         | 1.3-1.6em       | 2em               | 2.8em
Subtítulo            | 0.9em           | 1.1em             | 1.4em
Botones              | 1em + 14px pad  | 1.1em + 16px      | 1.35em + 22px
Íconos               | 2em             | 2.5em             | 3em
Texto cuerpo         | 0.8-0.9em       | 0.95em            | 1em
Padding general      | 10-15px         | 20px              | 20-30px

---

## Cómo Probar Cambios

### Paso 1: Editar functions.php

```
cp functions.php functions.php.backup.$(date +%Y%m%d_%H%M%S)
vi /home/obrasangiru/obras.angiru.uy/wp-content/themes/twentytwentyfive/functions.php
```
### Paso 2: Validar sintaxis

```
php -l /home/obrasangiru/obras.angiru.uy/wp-content/themes/twentytwentyfive/functions.php
```
### Paso 3: Limpiar cache

```
wp cache flush --path=/home/obrasangiru/obras.angiru.uy/
wp rewrite flush --path=/home/obrasangiru/obras.angiru.uy/
```
Forzar recarga de OPcache:
```
echo '<?php opcache_reset(); ?>' > /home/obrasangiru/obras.angiru.uy/opcache_reset.php
curl -s https://obras.angiru.uy/opcache_reset.php
rm /home/obrasangiru/obras.angiru.uy/opcache_reset.php
```
### Paso 4: Probar en navegador

```
echo "Landing (no logueado): https://obras.angiru.uy/"
echo "Login: https://obras.angiru.uy/wp-login.php"
echo "Dashboard (logueado): https://obras.angiru.uy/"
echo "Listado: https://obras.angiru.uy/entradas/"
```
### Paso 5: Probar en dispositivos

    - Chrome DevTools: F12 -> ícono de dispositivo -> probar tamaños
    - Android real: Chrome en móvil
    - iOS: Safari en iPhone/iPad

---

## Fix: Inicio en página logueada

El título `Inicio` aparece porque el tema renderiza el título de la página.
Para ocultarlo solo en el frontend (no en admin):

Agregar al final de functions.php, después de
     `obras_add_viewport_meta():`

```
// Ocultar título de página en frontend para página "Inicio"

add_action( 'wp_head', 'obras_hide_frontend_page_title' );

function obras_hide_frontend_page_title() {
    if ( is_admin() ) {
        return;
    }
    if ( is_front_page() || is_page(11) ) {
        ?>
        <style>
            .wp-block-post-title,
            h1.entry-title,
            .page-title,
            .entry-title,
            header.entry-header {
                display: none !important;
            }
        </style>
        <?php
    }
}
```
**Comandos para aplicar:**

         1. Agregar la función al final de functions.php
         2. Validar sintaxis: php -l functions.php
         3. Limpiar cache: wp cache flush
         4. Probar logueado y no logueado
---

## Backup y Seguridad

### Antes de cualquier cambio:

```
cp /home/obrasangiru/obras.angiru.uy/wp-content/themes/twentytwentyfive/functions.php \
   /home/obrasangiru/obras.angiru.uy/wp-content/themes/twentytwentyfive/functions.php.backup.$(date +%Y%m%d_%H%M%S)
```
Backup de la base de datos (opcional pero recomendado):
```
wp db export /home/obrasangiru/backup-$(date +%Y%m%d).sql --path=/home/obrasangiru/obras.angiru.uy/
```
### Si algo sale mal:

```
cp /home/obrasangiru/obras.angiru.uy/wp-content/themes/twentytwentyfive/functions.php.backup.YYYYMMDD_HHMMSS \
   /home/obrasangiru/obras.angiru.uy/wp-content/themes/twentytwentyfive/functions.php
```

Limpiar cache y recargar:

```
wp cache flush --path=/home/obrasangiru/obras.angiru.uy/
```
---

## Checklist de Pruebas

Después de cada ajuste de CSS:
```

    [ ] Desktop Chrome: Se ve bien en 1920px?
    [ ] Desktop Firefox: Mismo aspecto que Chrome?  
    [ ] Tablet: Responsive en 768px?
    [ ] Android: Botones centrados, texto legible?
    [ ] iOS: Mismo comportamiento que Android?
    [ ] Logueado: Dashboard sin "Inicio"?
    [ ] No logueado: Landing sin elementos del tema?
    [ ] Login/Register: Logo centrado y proporcional?
```
---

## Notas Finales

    1. Unidad em vs px: Usá em para fuentes (escala con preferencias del usuario), px para layouts fijos.
    2. !important: Usalo solo cuando el tema sobrescribe tus estilos.
    3. Responsive primero: Diseñá para móvil y escalá hacia arriba (min-width media queries).
    4. Accesibilidad: No reduzcas fuentes por debajo de 0.8em o 12px.
    5. Performance: CSS inline en PHP está bien para este proyecto chico; si crece, considerá un archivo .css externo.

Tip profesional: Para ajustes rápidos sin tocar PHP, podés usar el `Customizer de WordPress -> "CSS Adicional"`, pero tené en cuenta que los estilos de login/register no se aplican desde ahí.

---

Ultima actualización: Marzo 2026``
Proyecto: Obras Angirü - Bitácora de Obra
