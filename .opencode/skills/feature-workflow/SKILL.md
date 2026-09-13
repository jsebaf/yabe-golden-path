---
name: feature-workflow
description: Usar al iniciar, implementar, verificar o finalizar una feature relacionada con un issue, current-feature.md o el workflow de features del proyecto.
---

# Workflow De Features

Usa este skill para trabajar con un issue de una feature, el descriptor de la feature actual o cualquier fase del workflow de features del proyecto.

## Contexto Requerido

Antes de actuar sobre una tarea de una feature, lee estos archivos:

- `context/current-feature.md`
- `context/current-feature-file-spec.md`
- `context/feature-workflow.md`
- `context/coding-conventions.md`

Considera esos archivos la fuente de verdad para la feature actual, el formato del descriptor, los límites de las fases y las convenciones de código.

Mientras haya una feature activa, identifica el issue asociado mediante la línea exacta `- Issue: #<number>` dentro de `## Notas`. No intentes inferir el número desde texto libre.

## Fases

El workflow tiene tres fases explícitas:

1. **Inicio:** preparar el contexto desde el issue y establecer el issue como `in-progress`.
2. **Implementación y verificación:** implementar la feature y verificar sus requisitos y criterios de aceptación.
3. **Finalización:** actualizar el contexto y establecer el issue como `done`.

No avances a una fase posterior sin una solicitud explícita del usuario. Después de completar una fase, informa de lo realizado y detente.

## Secuencia De Comandos

Para una feature implementada y verificada:

- Usa `/create-pr <issue-number>` para publicar los cambios y crear la PR tempranamente.
- Permite que la misma rama reciba nuevos commits durante la revisión.
- Usa `/finish-feature <issue-number>` para completar la fase de Finalización en esa misma rama.
- Ese comando actualiza y limpia el descriptor, crea el commit final, hace `push` de la rama y actualiza las etiquetas del issue.
- Nunca hagas `push` directamente a la rama base.

## Descriptor De La Feature Actual

Al iniciar una feature:

- Actualiza el encabezado de primer nivel con el nombre de la feature.
- Actualiza `## Objetivos` y `## Notas` a partir del issue.
- Incluye en `## Notas` la referencia exacta `- Issue: #<number>`.
- Conserva `## Histórico` exactamente; no añadas una entrada de inicio.

Al finalizar una feature:

- Añade una única entrada concisa al principio de `## Histórico`.
- Nunca elimines ni reordenes entradas existentes del histórico.

Al reiniciar el descriptor, conserva sus encabezados de sección y el histórico completo.

## Convenciones Del Proyecto

- Mantén el código, los nombres de archivo, los identificadores, los comentarios y la documentación dentro del código en inglés.
- Sigue las convenciones existentes de Laravel y ejecuta Laravel Pint al formatear cambios de PHP.
- Mantén los cambios simples, legibles y limitados a la feature.
- No introduzcas cambios de estilo no relacionados ni código de compatibilidad innecesario.

## Operaciones De GitHub

- Usa Markdown válido para el contenido de issues y pull requests.
- Usa saltos de línea reales, nunca secuencias literales `\n`.
- Usa `--body-file` o un mecanismo equivalente para cuerpos multilínea.
- Conserva la información existente del issue al cambiar su estado o sus etiquetas.
