---
description: Crear un pull request con los cambios de una tarea y cerrar su issue al fusionarlo.
agent: build
---

Prepara y crea un pull request para el issue de GitHub proporcionado en `$ARGUMENTS`.

Antes de hacer cualquier otra cosa, carga y sigue el skill `pull-request`. Si el issue forma parte del workflow de una feature, carga también el skill `feature-workflow`.

## Entrada

- Trata `$ARGUMENTS` como el número del issue.
- Si no se proporciona un número de issue, solicítalo y no continúes.

## Preparación

1. Comprueba la rama actual, el remoto, el estado de Git y el historial reciente.
2. Inspecciona el issue y confirma que corresponde a los cambios locales.
3. Revisa `git status`, `git diff` y los commits de la rama que todavía no estén en la rama base. Determina todos los archivos modificados por esta tarea, incluidos los archivos nuevos.
4. Excluye cambios ajenos, temporales, generados y secretos. No reviertas cambios ajenos.
5. Ejecuta las pruebas y comprobaciones requeridas por la tarea.
6. Comprueba si ya existe una PR abierta para la rama actual.
7. Revisa el diff final y muestra las rutas que se incluirán.

Si detectas cambios mezclados, una rama incorrecta, verificaciones fallidas o cualquier otra condición insegura, detente e informa del problema.

Si ya existe una PR para la rama actual, no crees otra. Informa de su URL y detente, salvo que el usuario solicite explícitamente preparar o publicar cambios adicionales.

## Confirmación

Presenta al usuario:

- La rama y el mensaje del commit que se creará y publicará, si aún hay cambios sin commit.
- Todos los archivos que se añadirán.
- Los commits de la tarea que ya estén publicados, si la rama está limpia tras ejecutar `finish-feature`.
- Las verificaciones ejecutadas y sus resultados.
- El título previsto de la PR.
- La referencia `Closes #<issue-number>` que se incluirá en su cuerpo.

Solicita confirmación explícita antes de hacer commit, `push` o crear la PR.

## Publicación

Después de recibir la confirmación:

1. Si hay cambios sin commit, añade explícitamente todos los archivos de la tarea y crea el commit.
2. Si la rama está por delante del remoto, haz `push` sin `--force`.
3. Si `finish-feature` ya publicó todos los commits de la tarea, no crees un commit vacío.
4. Crea la PR contra la rama base por defecto del repositorio.
5. Usa un cuerpo Markdown multilínea mediante `--body-file` o un mecanismo equivalente, incluyendo `Closes #<issue-number>`.
6. Informa de la URL de la PR y detente.

No cierres el issue directamente, no fusiones la PR y no marques el issue como cerrado manualmente. GitHub lo cerrará cuando se fusione la PR.
