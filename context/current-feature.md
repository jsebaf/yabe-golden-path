# Feature actual

## Objetivos


## Notas


## Histórico

- 2026-09-17: Se implementó y verificó el workflow manual de GitHub Actions para construir y desplegar la imagen Docker en un VPS mediante SSH, con Compose de producción y persistencia SQLite.

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
