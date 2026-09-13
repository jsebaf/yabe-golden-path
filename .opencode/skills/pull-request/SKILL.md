---
name: pull-request
description: Usar al preparar, publicar o crear un pull request con los cambios de una tarea y un issue de GitHub.
---

# Pull Request

Usa este skill cuando el usuario solicite preparar o crear un pull request. Las acciones de commit, `push` y creación de la PR son externas y requieren confirmación explícita antes de ejecutarse.

## Preconditions

Antes de publicar cambios:

- Confirma el número del issue asociado.
- Comprueba la rama actual y asegúrate de que no es la rama base del repositorio.
- Comprueba que el remoto y la autenticación de GitHub están disponibles.
- Revisa `git status`, `git diff` y el historial reciente.
- Comprueba los criterios de aceptación y las verificaciones de la tarea.

Si alguna precondición no se cumple, detente y solicita la información o acción necesaria.

## Scope Of Changes

Incluye todos los archivos modificados por la tarea, tanto tracked como untracked, siempre que pertenezcan a su alcance.

- No uses `git add -A` ni `git add .` de forma ciega.
- Determina y muestra las rutas que se van a incluir.
- Excluye cambios ajenos, temporales, generados y secretos.
- Si un archivo contiene cambios mezclados de varias tareas, detente y solicita instrucciones.
- Conserva los cambios ajenos del worktree; no los reviertas ni los sobrescribas.

## Verification

Antes del commit:

- Ejecuta las pruebas y comprobaciones definidas por la tarea.
- Ejecuta Laravel Pint cuando haya cambios PHP que deban formatearse.
- Revisa de nuevo el diff staged y confirma que solo contiene los archivos de la tarea.
- Si una verificación falla, no publiques la PR sin informar del fallo y recibir instrucciones.

## Commit And Push

Después de que el usuario confirme el alcance y las acciones:

Si hay cambios de la tarea sin commit:

1. Añade explícitamente todos los archivos de la tarea.
2. Crea un commit con un mensaje breve y coherente con el historial del repositorio.
3. Haz `push` de la rama actual a su remoto, sin `--force`.
4. Comprueba que el commit publicado coincide con el commit revisado.

Si la rama ya está limpia porque `finish-feature` publicó el commit, no crees un commit vacío. Comprueba que los commits de la tarea están en la rama actual y que la rama está publicada antes de crear la PR.

No hagas commit de cambios ajenos ni modifiques la configuración de Git.

## Pull Request

Crea la PR contra la rama base por defecto del repositorio, salvo que el usuario indique otra.

El cuerpo debe incluir:

- Un resumen conciso de los cambios.
- Las verificaciones ejecutadas y su resultado.
- La referencia `Closes #<issue-number>` para que GitHub cierre el issue al fusionar la PR.

Usa Markdown válido, saltos de línea reales y `--body-file` o un mecanismo equivalente para el cuerpo multilínea.

No cierres el issue directamente, no fusiones la PR y no hagas `push --force`. Después de crear la PR, informa de su URL y detente.
