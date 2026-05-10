# Bitácora de Obra — Especificación funcional
**Proyecto Angirü · Versión 0.2**
*Plataforma: WordPress · Fecha: Abril 2026*

---

## 0. Glosario

| Término | Definición |
|---|---|
| **ndmcp** | Acrónimo colectivo para los cinco tipos de contenido del sitio: **N**otas, **D**ocumentos, **M**ateriales, **C**atálogos y **P**lanos |
| **Nota** | Elemento atómico de la Bitácora. Entrada redactada por un usuario que puede referenciar cualquier otro ndmcp |
| **Bitácora de Obra** | El conjunto cronológico de Notas públicas; columna vertebral del sitio |
| **Bib. de medios** | Biblioteca de medios de WordPress; repositorio central de archivos multimedia y documentos |
| **Miembro** | Usuario estándar del sitio (ver sección Roles) |
| **Administrador** | Superusuario con control total del sitio |
| **Moderador** | Rol intermedio reservado para uso futuro (fase 2) |
| **ABM** | Alta, Baja y Modificación; operaciones básicas de gestión de registros |

---

## 1. Resumen ejecutivo

**Propósito principal:** Constituir la bitácora digital de la obra: un registro cronológico, consultable y referenciable de las decisiones, avances, materiales y documentos del proceso constructivo.

**Usuarios:** Miembros del Proyecto Angirü (propietarios), arquitectos, equipo de la empresa constructora y gestores administrativos de la obra.

**Objetivo secundario:** El sistema deberá servir como fuente de experiencia documentada para las obras de la segunda cohorte de miembros del Proyecto Angirü, previstas para 2027.

**Contexto:** Angirü —vocablo guaraní que significa "amigo del alma"— es un proyecto comunitario integrado por aproximadamente 30 personas, en su mayoría médicos de la misma generación universitaria. En esta etapa se construyen 8 viviendas unifamiliares sobre un territorio de propiedad común. Los miembros fundadores se conocen desde hace más de 5 años y comparten el objetivo de vivir y desarrollar allí su proyecto de vida en comunidad.

**Plataforma:** WordPress. Se priorizará el uso de funcionalidades nativas y plugins del ecosistema estándar antes de desarrollar soluciones custom.

---

## 2. Público objetivo y consideraciones de diseño

Los usuarios principales son personas con alta capacidad intelectual y analítica pero con experiencia variable en herramientas digitales de obra. El contexto de uso es campo: tablet o dispositivo móvil, conectividad intermitente, condiciones físicas exigentes.

Principios de diseño derivados:
- La **entrada de datos debe ser simple y rápida** (pocos campos obligatorios, formularios cortos).
- El **sistema debe guardar contexto de forma automática** en segundo plano (fecha, autor, hora).
- La interfaz debe ser **legible y sin ambigüedades** en pantallas de tamaño reducido.
- **El diseño debe ser responsive.** La grilla de tres columnas (25% / 50% / 25%) aplica a pantallas de escritorio. En dispositivos móviles, el área útil ocupa el 100% del ancho disponible y los botones se reorganizan en columnas de una o dos unidades.

---

## 3. Tokens de diseño visual

| Elemento | Valor |
|---|---|
| Grilla desktop | 3 columnas: 25% izquierda — 50% central — 25% derecha |
| Área útil | Columna central. Alineación: centrada |
| Fuente títulos (T1) | 20 px |
| Fuente subtítulos (T2) | 12 px |
| Fuente footer de página | 10 px |
| Botones del dashboard | Cuadrados, tamaño uniforme, icono + etiqueta |
| Interacción de botones | Color activo + hover con texto descriptivo breve |

---

## 4. Arquitectura de contenidos (WordPress)

Los cinco tipos de contenido se implementan como **Custom Post Types (CPT)**:

| CPT | Slug sugerido |
|---|---|
| Notas | `obra_nota` |
| Documentos | `obra_documento` |
| Materiales | `obra_material` |
| Catálogos | `obra_catalogo` |
| Planos | `obra_plano` |

El campo **Clase de contenido** se implementa como **Custom Taxonomy** compartida entre los CPT, editable desde el panel de administración de WordPress por el Administrador.

---

## 5. Roles y permisos

| Rol WP | Nombre funcional | Descripción |
|---|---|---|
| `administrator` | Administrador | Control total: usuarios, contenidos, taxonomías y configuración del sitio |
| *(reservado)* | Moderador | Rol intermedio a definir en fase 2 o durante la beta. Casos de uso tentativos: aprobar registros, editar ndmcp de otros sin poder eliminarlos |
| `author` | Miembro | Usuario estándar. Dueño de sus propios ndmcp. Ve todas las Notas públicas |

**Permisos sobre ndmcp:**

| Acción | Miembro (propio) | Miembro (ajeno) | Administrador |
|---|---|---|---|
| Ver (público) | ✅ | ✅ | ✅ |
| Ver (privado) | ✅ | ❌ | ✅ |
| Crear | ✅ | — | ✅ |
| Editar | ✅ | ❌ | ✅ |
| Eliminar | ✅ | ❌ | ✅ |

**Eliminación con trazabilidad:** Cuando un ndmcp es eliminado, las menciones, enlaces o referencias a ese contenido en otros ndmcp del sitio son reemplazadas automáticamente por la leyenda:
> `[El usuario "nombre_de_usuario" eliminó este/a <tipo_de_ndmcp>]`

---

## 6. Flujo de registro de usuarios

```
1. El usuario completa el formulario de registro (campos: nombre de usuario [obligatorio],
   email [obligatorio], contraseña).

2. WordPress envía un correo automático al Administrador con la solicitud.

3. El Administrador recibe el correo con tres acciones directas:
      [Aprobar]   [Rechazar]   [Ver solicitud]

4a. Si aprueba → el usuario recibe un correo de bienvenida y puede acceder al sitio.
4b. Si rechaza → el usuario recibe una notificación (texto a definir).
```

*Implementación sugerida:* plugin **New User Approve** o configuración nativa de WordPress de aprobación manual de usuarios. No requiere desarrollo custom.

**Recuperación de contraseña:** se utilizará el mecanismo nativo de WordPress (enlace por correo electrónico).

---

## 7. Portada (landing.php)

### Estructura visual

```
+---------------------------+---------------------------+---------------------------+
|          25%              |           50%             |          25%              |
|        (vacío)            |       ÁREA ÚTIL           |        (vacío)            |
+---------------------------+---------------------------+---------------------------+
```

### Contenido del área útil (de arriba hacia abajo)

```
T1  Bitácora de Obra                          [20px]
    [espacio para logo]
T2  Gestión simplificada de proyectos         [12px]
    en construcción.
T2  Documentación, materiales y seguimiento   [12px]
    en un solo lugar.

    [ Acceder ]  [ Registrarse ]              ← botones pequeños, funcionales

+-------------+-------------+-------------+
|     ✍️      |     📄      |     🧰      |
| Entradas    | Documentos  | Materiales  |  ← botones grandes, cuadrados, INERTES
| Rápidas     |             |             |
+-------------+-------------+-------------+
|     📚      |     📐      |     🔲      |
| Catálogos   |   Planos    | Placeholder |
|             |             |             |
+-------------+-------------+-------------+
```

**Nota:** los botones cuadrados en la portada son exclusivamente informativos (demostración visual). No ejecutan ninguna acción. Los usuarios autenticados son redirigidos al Dashboard.

### Leyendas de los seis botones de portada

| Ícono | T1 (20px) | T2 (12px) |
|---|---|---|
| ✍️ | Entradas Rápidas | Registrá actividades y novedades de obra en minutos |
| 📄 | Documentos | Accedé a planos, notas e instructivos cuando los necesites |
| 🧰 | Materiales | Seguimiento de recursos y ubicación en la obra |
| 📚 | Catálogos | Consultá catálogos de productos y materiales |
| 📐 | Planos | Visualizá planos en PDF e imágenes de la obra |
| 🔲 | Placeholder | Botón temporal reservado para funcionalidad futura |

### Footer de página (portada y Dashboard)

```
🏗️  Obras Angirü – Gestión de proyectos en construcción
    Acceso exclusivo para miembros del proyecto
```
Tamaño de fuente: 10 px.

---

## 8. Dashboard

### Diferencias respecto a la portada

- Los botones **[Acceder]** y **[Registrarse]** son reemplazados por el botón **[Menú de usuario]**.
- Todos los botones cuadrados son **funcionales**.
- El botón **[Placeholder]** permanece visible pero inactivo hasta que se defina su funcionalidad.

### Grilla de botones del Dashboard

```
+-------------+-------------+-------------+
|     ✍️      |     📋      |     📄      |
| Nueva Nota  |  Ver Notas  | Documentos  |
+-------------+-------------+-------------+
|     🧰      |     📚      |     📐      |
| Materiales  | Catálogos   |   Planos    |
+-------------+-------------+-------------+
```

### Menú de usuario

Ubicado en la esquina superior derecha del área útil. Su etiqueta visible es el **nombre de usuario** del miembro activo.

Al hacer clic se despliega un menú con dos opciones:
- **Ir a Mi Perfil**
- **Cerrar sesión**

---

## 9. Perfil de usuario

Accesible desde el Menú de usuario. Campos:

| Campo | Editable |
|---|---|
| Nombre de usuario | ❌ |
| Correo electrónico | ✅ |
| Contraseña | ✅ |
| Foto / avatar | ✅ |
| Texto libre (campo de uso libre) | ✅ |

---

## 10. Notas y Bitácora de Obra

### Propósito

Las Notas son el elemento central del sitio. El conjunto cronológico de Notas públicas constituye la **Bitácora de Obra**. Cada Nota puede referenciar uno o más ndmcp, convirtiendo la Bitácora en el hilo conductor que da sentido al resto del contenido.

### Campos de una Nota

| Campo | Tipo | Obligatorio | Ingreso |
|---|---|---|---|
| Título | Texto corto | ✅ | Manual |
| Subtítulo / descripción breve | Texto corto | ❌ | Manual |
| Cuerpo | Editor de texto enriquecido | ✅ | Manual |
| Clase de contenido | Lista de valores (taxonomía) | ✅ | Selección |
| Visibilidad | Pública / Privada | ✅ | Selección |
| Autor | Texto | ✅ | Automático (usuario activo) |
| Fecha y hora | Fecha + hora + minuto (+ segundos si se requiere para ordenación, no visible) | ✅ | Automático |
| Adjuntos | Archivos (máx. 5) | ❌ | Manual |
| Referencias | Enlaces a otros ndmcp o a la bib. de medios | ❌ | Manual |

**Sobre la fecha:** la fecha registrada es siempre la del momento de creación. No es editable por el usuario. Si se necesita retrocargar una entrada (documentar algo ocurrido en días anteriores), se podrá incluir esa aclaración en el cuerpo o subtítulo de la Nota. *(Decisión pendiente de validación con los usuarios.)*

**Sobre la Clase de contenido:** lista de valores configurable mediante ABM simple desde el panel de administración de WordPress, accesible únicamente al Administrador. El uso real de los valores servirá como indicador para ajustar la lista a lo largo del tiempo.

### Editor de texto enriquecido

Editor básico, con las siguientes capacidades:
- Formato: **negrita**, *itálica*
- Inserción de imágenes (desde la bib. de medios o por carga directa del usuario; los archivos cargados quedan disponibles en la bib. de medios)
- Inserción de enlaces externos e internos al sitio
- Inserción de adjuntos en los formatos: `.pdf`, `.txt`, `.jpg`, `.png`, `.xlsx`, `.ods` y otros formatos de oficina comunes

*Implementación sugerida:* TinyMCE simplificado mediante el plugin **Advanced Editor Tools**, configurado para mostrar solo las opciones necesarias. Se evitará el editor Gutenberg por bloque, que puede resultar complejo para usuarios con baja experiencia en herramientas digitales.

### Pie de nota (automático)

El pie de nota se genera automáticamente y muestra:
- Adjuntos descargables o desplegables (con nombre e ícono de tipo de archivo)
- Clase de contenido
- Autor
- Fecha y hora

### Visibilidad

- **Pública:** visible en la Lista de Notas para todos los usuarios del sitio.
- **Privada:** visible únicamente para el autor y el Administrador. No aparece en la Bitácora de Obra.

El sistema no gestiona el compartido externo de Notas privadas. Eso queda a criterio del usuario (correo, WhatsApp, etc.).

---

## 11. Lista de Notas (Bitácora)

Accesible desde el botón **Ver Notas** del Dashboard. Muestra únicamente las Notas públicas.

**Ordenación por defecto:** fecha descendente (más reciente primero).
**Ordenaciones disponibles:** por Autor (luego por fecha) · por Clase de contenido (luego por fecha).
**Paginación:** clásica con números. Cantidad de ítems por página: a definir (sugerido: 20).

### Aspecto de cada elemento en la lista

```
------------------------------------------------
Avance de movimientos de tierra
📅 20/04/2026  ✍️ Alejandra Severgnini  🏷️ Visita de Obra
✏️ Editar   🗑 Mover a papelera
------------------------------------------------
Bienvenida a Bitácora de Obra
📅 20/04/2026  ✍️ Alejandra Severgnini  🏷️ Memo
✏️ Editar   🗑 Mover a papelera
------------------------------------------------
```

Los íconos **Editar** y **Mover a papelera** son visibles (y activos) únicamente para el autor de la Nota y para el Administrador.

### Papelera

La eliminación mueve la Nota a una papelera. El Administrador puede vaciar la papelera o restaurar elementos. *(Decisión pendiente: ¿el usuario estándar también puede restaurar desde la papelera o solo el Administrador?)*

---

## 12. Documentos, Materiales, Catálogos y Planos

Cada uno de estos tipos de contenido es análogo a las Notas, con las siguientes diferencias:

- **No pueden referenciar otros ndmcp.** Solo las Notas tienen esa capacidad.
- Sus listas (Lista de Documentos, Lista de Materiales, etc.) tienen el mismo aspecto y comportamiento que la Lista de Notas.
- Son accesibles desde los botones correspondientes del Dashboard.
- Cada elemento tiene su vista de detalle desplegable.

La estructura de campos, el editor, la paginación, los permisos de edición y eliminación, y el comportamiento de la papelera son idénticos a los de las Notas.

---

## 13. Flujos de usuario principales

### Crear una Nota
```
Dashboard → [Nueva Nota]
→ Formulario: Título (obligatorio), Subtítulo, Clase de contenido (obligatorio),
  Visibilidad (Pública/Privada), Cuerpo (editor), Adjuntos (máx. 5), Referencias
→ [Guardar] → redirección a la Lista de Notas
```

### Ver la Bitácora
```
Dashboard → [Ver Notas] → Lista de Notas (públicas, desc. por fecha)
→ Clic en título → Vista de detalle de la Nota
```

### Editar una Nota propia
```
Lista de Notas → [✏️ Editar] → Formulario con campos pre-cargados → [Guardar]
```

### Eliminar una Nota propia
```
Lista de Notas → [🗑 Mover a papelera] → Confirmación → Nota movida a papelera
```

---

## 14. Pendientes y backlog

| Ítem | Prioridad | Notas |
|---|---|---|
| Diseño responsive detallado | Alta | Comportamiento en móvil no especificado aún |
| Criterios de navegabilidad entre vistas | Alta | Breadcrumbs, botón "volver", flujos de retorno |
| Estados de una Nota: ¿borrador / publicado? | Media | ¿Puede un miembro guardar sin publicar? |
| Restauración desde papelera por usuario estándar | Media | Solo Administrador o también el autor |
| Retrocargar fecha de nota | Media | ¿Se habilita edición de fecha o se documenta en el cuerpo? |
| Búsqueda y filtros en listas | Media | Sin mecanismo de búsqueda definido aún |
| Rol Moderador | Baja | Definir casos de uso y permisos en fase 2 o beta |
| Notificación al rechazar registro | Baja | Texto del correo a redactar |
| Ítems por página en paginación | Baja | Sugerido: 20 |
| Cantidad exacta de tipos de archivo aceptados | Baja | Lista base definida; puede ampliarse |

---

*Fin de la especificación v0.2 — Próxima revisión: incorporar decisiones sobre pendientes de alta prioridad.*
