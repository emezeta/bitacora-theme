# OBSOLETO - La descripción ha quedado obsoleta. 
<br />
Una versión actual, está disponible en `Especificación Funcional.md`
---

Quiero un sitio para llevar anotaciones de campo en obras civiles de pequeño porte, para usuarios de 60 años o más, con una alfabetización digital de unos 25%.
La portada deberá tener:

Portada a tres columnas:
25% izquierda - 50% central - 25% derecha.

El área útil en general será siempre en los límites de la columna central.
Alineación: Central

Un logo y estos textos a modo de títulos y subtítulos:
    Orden:
        T1 Bitácora de Obra
        [espacio para logo]
        ST2 Gestión simplificada de proyectos en construcción.
        ST3 Documentación, materiales y seguimiento en un solo lugar.

Dos botones vivos y seis inhertes. Los dos vivos son Acceder y Registrarse y deberán tener menos tamaño que los seis restantes meramente informativos o demo. Estos 6 serán de buen tamaño, de porte cuadrado ocupando la columna central. 3 arriba y 3 abajo.


Las leyendas de los 6 botones cuadrados serán respectivamente las siguientes: (izquierda a derecha y de arriba abajo) con íconos decorativos.
Font size: T1-20, T2-12

Botones:
✍️
T1Entradas Rápidas
T2Registra actividades y novedades de obra en minutos

📄
T1Documentos
T2Accedé a planos, notas e instructivos cuando los necesites

🧰
T1Materiales
T2Seguimiento de recursos y ubicación en la obra

📚
T1Catálogos
T2Consultá catálogos de productos y materiales

📐
T1Planos
T2Visualizá planos en PDF e imágenes de la obra

🛸
T1Placeholder
T2Botón temporal – landing.php : obras-feature-alien


Footer: dos líneas un ícono.
Font size: 10
🏗️ Obras Angirü – Gestión de proyectos en construcción
Acceso exclusivo para miembros del proyecto


============================================================

## Dashboard

Usaremos aquí la denominación 'ndmcp' para significar Notas, Documentos, Materiales, Catálogos y Planos.

El aspecto de este Dashboard, es exactamente igual a de la portada. Con una diferencia visual: aquí no estarán los botones [Acceder] ni [Registrarse]. En su lugar habrá un botón "Menú de Usuario" que se describirá. Asimismo todos los botones serán funcionales.


# Usuarios:

Estos estarán sujetos a una dos jerarquías de permisos, un supervisor plenipotenciario del sitio y los usuarios normales. Ambos roles son denominados aquí como usuarios. Se indicará cuando se trate ddiferencialmente al supervisor. Todos tienen su página de Perfil, a la que se accede desde el "Menú de Usuario", el cuál se ubica arriba a derecha como se indicó antes. La página de perfil es básica, consite en Nombre de usuario, email y pasword, una foto o imagen de avatar y un pequeño campo de texto de uso libre. Menos menos el nombre de usuario, todos son campos editables.

El usuario común es dueño plenipotenciario de sus ndmcp(s).
La eliminación de ndmcp será informada al usuario actual, advirtiendo sobre las menciones, enlaces o referencias en otros ndmcp del sitio, que serán reemplazadas por su nombre de usuario con la leyenda [el usuarios "nombre_de_usuario" eliminó este/a `ndmcp`].
El supervisor podrá modificar uno o todos los campos del ndmcp o eliminar uno o todos ndmcp.


# Propósito:

El Propósito general del sitio es la documentación, repositorio de diferentes documentos, materiales, fotos e imágenes, etc.

El elemento atómico fundamental de la documentación es la "Nota". Una "Nota" consiste en un Título (obligatorio), Subtítulo o descripción breve (opcional), Fecha (automático), Autor (automático), un Tipo o Tema (lista de valores) y un campo para permitir opcionalmente adjuntos. El campo "Tipo" o "Tema" o "Clase de contenido", -quizá este último sea la denominación de campo más decuada-, es obligatorio. Opcionalmente el supervisor pordá apliar la lista de valores disponibles para ese campo, dado que el uso será un indicador desicivo para adecuar los valores.

El cuerpo deberá tener un editor de texto enriquecido, aceptará imágenes y enlaces externos o internos al sitio y archivos adjuntos con los formatos .pdf, .txt, .jpg, .png, quizá alguno más. Estos adjuntos podrán ser aportes del usuario, o un banco de archivos que contendrá todos los files aportados o subidos por el administrador. No obstante será un editor básico, con pocas opciones, del tipo negritas, cursiva, italica. El cuerpo de la Nota aceptará campos de tipo enlace, además del texto.

Campos:
Título, Fecha, Autor, Clase de contenido, Adjuntos

y un pequeño Footer de elemento que refiere al tipo de Nota: Memo, Visita de Obra, Novedad,


* Notas y Lista de Notas *
Para lograr el Propósito se implementará un único discurrir continuo (lista eventualmente paginable) de "Notas" ingresadas por los usuarios. Quién crea la Nota será su autor/dueño. Esta "Lista de Notas" es la columna vertebral del sitio. 

El primer botón será el acceso al Editor de Notas. A la lista de Notas se accede mediante el segundo botón del Dashboard "Ver Notas". Será una lista por defecto ordenada (desc) por Fecha(hora, minuto) y ordenable por Autor(fecha) o por Tema(fecha). Los elementos visibles en la lista serán: Título (de la nota), Fecha (de la nota), Autor (de la nota). Además de los elementos (campos) visibles de la nota en la lista de notas, habrá dos pequeños íconos con los enlaces a [Editar] (acceso a la edición de la nota) o [Eliminar] (eliminar la nota) que solo serán visibles (o activos) para el dueño de la nota y para el supervisor.

Aspecto de la Lista de Notas
------------------------------------------------
(titulo) Avance de movimientos de tierra
(fecha)  📅 20/04/2026 ✍️ Alejandra Severgnini
(íconos) ✏️ Editar     🗑 Mover a papelera
------------------------------------------------
(titulo) Bienvenida a Bitácora de Obra
(fecha)  📅 20/04/2026 ✍️ Alejandra Severgnini
(íconos) ✏️ Editar     🗑 Mover a papelera
------------------------------------------------

Cada uno de los ndmcp se implementará analogamente a las Notas y su lista de notas.



Descripción de botones:

Menu de Usuario: Está ubicado donde se indicó y su título será Nombre_de_usuario (en el form de enrolamiento ese será un campo oblidatorio). Al click se habrirá un menú deplegable con dos controles visible: Ir a [Mi Perfil] y [Cerrar].

Los seis botones, -ahora botones vivos, son iguales en tamaño y disposición a los de la portada, con un color "activo", hover o pop-up con mínimo texto descriptivo. Ya se describieron los primeros dos botones de la primera fila. El resto de los botoes serán en su visual igual al de portada para cada botón, contenendo un ícono y una etiqueta de texto.

+-------------+-------------+-------------+
|    ✍️       |      📋     |     📄      |
| Nueva Nota  |  Ver Notas  | Documentos  |
|_____________|_____________|_____________|
|             |             |             |
|    🧰       |      📚     |      📐     |
| Materiales  |  Catálogos  |   Planos    |
|             |             |             |
+-------------+-------------+-------------+


Nueva Nota: Crea una entrada que consiste en un tíitulos, una descripción breve (opcional) un cuerpo y un footer.

Ver Notas: Es el acceso a la "Lista de Notas".

Los botones Documentos, Materiales, Catálogos, Planos, analogamente son los repectivos accesos a las listas de su especie.

El despliegue de las listas será similar a la descita para "Lista de Notas"
Todas los elementos de lista tendrán debajo

Faltaría definir criterios de navegabilidad

