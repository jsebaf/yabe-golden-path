# Instrucciones para el agente

## Flujo de features

Cuando la tarea implique iniciar, implementar, verificar o finalizar una feature,
un issue o el descriptor `context/current-feature.md`, cargar el skill
`feature-workflow` antes de actuar.

El skill determina qué archivos de contexto deben leerse y cuándo. No es
necesario leer esos archivos en sesiones que no estén relacionadas con el flujo
de features.

## GitHub

Al crear o modificar issues o pull requests:

- Utilizar Markdown válido.
- Los saltos de línea deben ser saltos reales, no la cadena literal `\n`.
- Para cuerpos con varias líneas, utilizar `--body-file` o un mecanismo equivalente que preserve correctamente el formato.
