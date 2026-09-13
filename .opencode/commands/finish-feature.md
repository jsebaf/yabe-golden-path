---
description: Finalizar una feature en la rama actual y preparar sus cambios para crear el pull request.
agent: build
---

Finaliza la feature asociada al issue de GitHub proporcionado en `$ARGUMENTS` o identificado en el descriptor de la feature actual.

Antes de hacer cualquier otra cosa, carga y sigue el skill `feature-workflow`.

## Entrada

- `$ARGUMENTS` es opcional y, si se proporciona, se trata como el número del issue.
- Si no se proporciona, lee la línea exacta `- Issue: #<number>` de `## Notas` en `context/current-feature.md`.
- Si se proporcionan ambos valores y no coinciden, detente y solicita aclaración.
- Si no se encuentra ningún número de issue, solicítalo y no continúes.

## Precondiciones

1. Resuelve el número del issue usando `$ARGUMENTS` o la referencia estructurada del descriptor antes de modificarlo.
2. Comprueba que el issue existe y que corresponde a la feature actual.
3. Comprueba que la implementación está verificada y que se han cumplido sus criterios de aceptación.
4. Comprueba la rama actual y detente si es la rama base del repositorio (`main` u otra rama por defecto).
5. Revisa `git status`, `git diff` y el historial reciente.
6. Determina todos los archivos modificados por esta feature, incluidos los archivos nuevos, y excluye cambios ajenos, temporales, generados y secretos.

Si alguna precondición no se cumple o hay cambios mezclados, detente e informa del problema.

## Actualización Del Contexto

Actualiza `context/current-feature.md` de la siguiente forma:

1. Añade al principio de `## Histórico` una entrada de una sola línea que resuma el trabajo realizado.
2. Cambia el encabezado de primer nivel a `# Feature actual`.
3. Vacía el contenido de `## Objetivos`.
4. Vacía el contenido de `## Notas`.
5. Conserva todos los encabezados y todas las entradas históricas anteriores.

No añadas un número de PR a la entrada porque la PR todavía no se ha creado.

## Confirmación

Antes de publicar cambios, muestra al usuario:

- La rama que se utilizará.
- Todos los archivos de la feature que se incluirán en el commit.
- El mensaje previsto del commit.
- Las verificaciones realizadas y sus resultados.
- Los cambios de etiquetas previstos: quitar `in-progress` y añadir `done`.

Solicita confirmación explícita antes de hacer commit, `push` o modificar las etiquetas del issue.

## Publicación

Después de recibir la confirmación:

1. Añade explícitamente todos los archivos de la feature, sin usar `git add -A` ni `git add .` de forma ciega.
2. Crea un commit con un mensaje breve y coherente con el historial del repositorio.
3. Haz `push` de la rama actual a su remoto, sin `--force` y nunca directamente a `main`.
4. Quita la etiqueta `in-progress` del issue.
5. Añade la etiqueta `done` al issue.
6. Informa del commit, la rama publicada y el estado final de las etiquetas.

Este comando solo ejecuta la fase de Finalización. No crea ni fusiona un pull request. Si ya existe una PR para la rama, el `push` final actualizará esa misma PR. Después de informar del resultado, detente y deja la PR lista para merge.
