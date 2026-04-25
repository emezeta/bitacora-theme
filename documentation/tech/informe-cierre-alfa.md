# Bitácora de Obra
## Informe de cierre de etapa ALFA

**Proyecto:** Bitácora de Obra  
**Etapa que cierra:** ALFA  
**Etapa que inicia:** BETA  
**Versión de referencia:** v0.1.0-beta  
**Fecha:** 2026-04-24

Desarrollado con asistencia AI.

---

## 1. Objetivo de la etapa ALFA

La etapa ALFA tuvo como objetivo estabilizar la base funcional de Bitácora de Obra, validar su modelo de uso real y consolidar una primera experiencia operativa coherente para usuarios no técnicos.

El foco principal estuvo en:

- definir una estructura clara y usable
- reducir fricción para usuarios con baja alfabetización digital
- estabilizar el frontend de trabajo
- corregir desvíos de modelo de datos
- limpiar la interfaz de edición
- dejar el sistema en condiciones de uso controlado

---

## 2. Principio rector del proyecto

**Ausencia de fricción > pureza técnica**

Bitácora de Obra está orientada a usuarios reales, no técnicos, y especialmente a perfiles que requieren una experiencia directa, clara y consistente.

Criterios permanentes del proyecto:

- simplicidad extrema
- mínima carga cognitiva
- consistencia entre pantallas
- reducción de decisiones innecesarias
- prioridad del reconocimiento sobre la exploración

---

## 3. Organización funcional del sistema

Bitácora quedó organizada en cinco **Secciones**:

- **Notas**
- **Documentos**
- **Materiales**
- **Catálogos**
- **Planos**

Dentro del proyecto, **Notas** es la sección principal y vertebral.  
Las demás secciones funcionan como soporte, consulta y referencia.

---

## 4. Estado alcanzado al cierre de ALFA

### 4.1. Estructura general
Se consolidó una base funcional estable del child theme, modularizada por responsabilidades y sin fallos estructurales activos conocidos.

### 4.2. Modelo de datos
Se corrigió el problema estructural que mezclaba Materiales, Catálogos y Planos bajo un modelo compartido.

Quedó adoptado el esquema correcto de entidades separadas:

- `bitacora`
- `documento_obra`
- `material_obra`
- `catalogo_obra`
- `plano_obra`

Esto permitió que cada sección tenga:

- su alta propia
- su listado propio
- su vista individual propia
- sus campos propios
- su navegación propia

### 4.3. Frontend
Quedaron operativos y coherentes:

- dashboard frontend
- listados frontend
- vistas individuales
- navegación contextual
- acciones de editar y mover a papelera
- control de acceso para usuarios no logueados

### 4.4. Editor
Se realizaron limpiezas de interfaz para reducir ruido operativo:

- ocultamiento del control de enlace permanente
- anulación del botón **Más**
- mantenimiento del botón **Enlace**
- ajuste de denominaciones visibles
- saneamiento de nomenclatura en la interfaz

### 4.5. Vocabulario funcional
Se adoptó **Secciones** como término principal para presentar el sistema a usuarios.

---

## 5. Validaciones funcionales realizadas

Durante esta etapa se verificó, en términos generales, el comportamiento sano de las cinco secciones en:

- alta de contenido
- guardado/publicación
- edición
- adjuntos
- listados
- vistas individuales
- acciones del autor
- control de acceso general

También quedó validado que:

- las listas funcionan correctamente
- las vistas individuales funcionan correctamente
- la separación entre secciones es operativa y visible
- la interfaz es sensiblemente más limpia que al inicio del refactor

---

## 6. Decisiones de diseño y funcionamiento ya consolidadas

### 6.1. Notas como eje central
Las **Notas** constituyen la base narrativa y cronológica de Bitácora.

### 6.2. Secciones como lenguaje de usuario
Para la presentación y uso del sistema se adopta el término **Secciones**.

### 6.3. Botón Enlace
El botón **Enlace** se conserva, especialmente por su valor estratégico en **Notas**, donde el enlazado interno entre contenidos del sistema es una capacidad importante.

### 6.4. Clases de contenido
Las clases de contenido quedan, por ahora, bajo un esquema controlado y gobernado, con posibilidad de revisión futura según el uso real en BETA.

---

## 7. Diferidos deliberadamente a BETA / RC

Los siguientes puntos no bloquean el cierre de ALFA y quedan diferidos de forma consciente:

### Para BETA
- ajustes finos derivados del uso real
- revisión de clases de contenido según demanda observada
- refinamiento del comportamiento del enlazado interno en Notas
- observación de pequeñas fricciones no detectadas en pruebas internas

### Para RC
- privacidad fina de Notas  
  - una Nota privada deberá ser visible sólo para su autor
- revisión más precisa de permisos si el uso real lo exige

---

## 8. Evaluación general del cierre ALFA

La etapa ALFA puede darse por cerrada de forma satisfactoria.

El sistema quedó:

- funcional
- coherente
- presentable
- razonablemente estable
- apto para uso controlado
- apto para iniciar BETA

Lo pendiente ya no pertenece al núcleo estructural del sistema, sino principalmente a una etapa de ajuste fino, observación de uso y refinamiento funcional.

---

## 9. Próxima etapa

Con el cierre de ALFA se da inicio a la etapa **BETA**, orientada a:

- observación de uso real
- validación con usuarios
- detección de fricciones residuales
- ajuste de vocabulario, clases y pequeños comportamientos
- preparación de reglas más finas de privacidad y permisos
