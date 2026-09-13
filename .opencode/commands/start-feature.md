---
description: Preparar una feature desde un issue de GitHub y detenerse antes de la implementación.
agent: build
---

Prepara la feature descrita por el issue de GitHub proporcionado en `$ARGUMENTS`.

Antes de hacer cualquier otra cosa, carga y sigue el skill `feature-workflow`. Lee los archivos de contexto requeridos por ese skill.

## Entrada

- Trata `$ARGUMENTS` como el número del issue.
- Si no se proporciona un número de issue, solicítalo al usuario y no continúes.

## Procedimiento

1. Inspecciona el issue, incluyendo título, descripción, etiquetas, comentarios y criterios de aceptación.
2. Resume el issue e identifica los requisitos que deben aparecer en el descriptor de la feature actual.
3. Actualiza `context/current-feature.md`:
   - Establece el encabezado de primer nivel con el nombre de la feature.
   - Completa `## Objetivos` con los requisitos y criterios de aceptación de la feature.
   - Completa `## Notas` con el contexto técnico y las suposiciones relevantes, incluyendo la línea exacta `- Issue: #<issue-number>`.
   - Conserva `## Histórico` exactamente y no añadas una entrada por iniciar la feature.
4. Establece el issue como `in-progress` usando el mecanismo de GitHub establecido por el repositorio. Conserva las etiquetas y el contenido existentes.
5. Informa de los cambios realizados en el issue, el descriptor y el estado.

## Límites

- Este comando ejecuta únicamente la fase de Inicio.
- No implementes código de aplicación, tests, cambios en OpenAPI, cambios en Postman ni ningún otro trabajo de la feature.
- No crees un pull request.
- No comiences Implementación y verificación ni Finalización.
- Detente después de informar de la fase de Inicio completada y espera las instrucciones del usuario.
