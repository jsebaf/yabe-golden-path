# Automatizar el despliegue mediante GitHub Actions

## Objetivos

- Crear un workflow en `.github/workflows/` ejecutable manualmente mediante `workflow_dispatch`.
- Obtener el código del repositorio y construir la imagen Docker utilizando el `Dockerfile` existente.
- Exportar la imagen con `docker save`, comprimirla si resulta conveniente y transferirla al VPS mediante SSH/SCP.
- Transferir al VPS el `compose.yaml` necesario para ejecutar la aplicación.
- Conectarse al VPS mediante SSH, cargar la imagen recibida en Docker y ejecutar o actualizar la aplicación con Docker Compose.
- Dejar la aplicación accesible en el puerto configurado para el despliegue.
- Permitir repetir el workflow para actualizar una instalación existente de forma idempotente en la medida de lo posible.
- Usar GitHub Secrets para `VPS_HOST`, `VPS_USER` y `VPS_SSH_KEY`; no almacenar secretos ni claves privadas en el repositorio.
- Utilizar la imagen construida por GitHub Actions en el `compose.yaml` de despliegue, conservando los datos de SQLite mediante el volumen definido en Compose y permitiendo añadir servicios en el futuro.

### Criterios de aceptación

- El workflow aparece en `.github/workflows/` y utiliza `workflow_dispatch`.
- El workflow contiene los pasos necesarios para construir, empaquetar, transferir y desplegar la imagen.
- El workflow utiliza GitHub Secrets para las credenciales del VPS.
- El VPS no necesita ejecutar `docker build`.
- El `compose.yaml` de despliegue utiliza la imagen construida por el workflow y conserva los datos de SQLite mediante su volumen.
- El workflow puede ejecutarse nuevamente para actualizar la aplicación.
- Los archivos generados se validan localmente en la medida de lo posible.
- El workflow no se ejecuta como parte de esta issue y no se realiza ningún despliegue en el VPS.
- Ningún secreto o clave privada se almacena en el repositorio.

## Notas

- Issue: #32
- El proyecto ya dispone de `Dockerfile`, script de entrada, `compose.yaml`, SQLite y un VPS Debian con Docker/Docker Compose y acceso SSH mediante clave.
- El `compose.yaml` actual está orientado a ejecución local y puede requerir adaptación para consumir una imagen previamente construida en lugar de construirla localmente.
- La solución debe analizar la configuración Docker existente antes de implementarse y debe limitarse a archivos del repositorio.
- Quedan fuera de alcance el aprovisionamiento del VPS, Debian, Docker o Docker Compose, DNS, HTTPS, Nginx, alta disponibilidad, rollback automático y monitorización avanzada.

## Histórico

- 2026-09-17: Se dockerizó la aplicación para ejecución local con Docker Compose, SQLite persistente, inicialización automática y documentación; se verificó con 19 tests y 91 assertions y se publicó en la PR #31.

- 2026-09-16: Se conectó el MCP Server con la persistencia SQLite real de Laravel, se añadieron estadísticas y manejo de errores, se verificó con 2 tests y se publicó en la PR #29.

- 2026-09-16: Se implementó y verificó el servidor MCP local con herramientas simuladas, transporte `stdio`, configuración de OpenCode, logging y documentación; se publicó en la PR #27.

- 2026-09-16: Se implementó y verificó la interfaz React con Tailwind para consultar disponibilidad, se publicó en la PR #23 y esta fue fusionada.
- 2026-09-15: Se sustituyó el servicio mock por persistencia Eloquent con migraciones, seeders y `EloquentDataService`; se adaptaron los tests con `RefreshDatabase`; se creó la PR #21.
- 2026-09-12: Se implementó y verificó el endpoint `POST /api/v1/availability`, con Feature Tests, colección Postman y la PR #16.
- 2026-09-11: Se implementaron y verificaron los endpoints `GET /api/v1/hotels` y `GET /api/v1/room-types` usando el servicio mock, con Feature Tests y colección Postman; se creó la PR #12.
- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
