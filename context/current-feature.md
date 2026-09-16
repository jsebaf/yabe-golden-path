# Conectar el MCP Server con los datos reales

## Objetivos

### Requisitos

- Conectar el MCP Server existente con la persistencia local real de la aplicación, reutilizando su configuración de acceso y evitando una segunda fuente de datos.
- Sustituir los datos simulados de `get_hotels`, `get_bookings` y `get_bookings_statistics` por consultas a la persistencia de la aplicación.
- Mantener la ejecución local mediante `stdio` y la compatibilidad con OpenCode.
- Mantener el registro de invocaciones y resultados en `mcp/logs/mcp.log` y, cuando el mecanismo existente lo permita, de los mensajes MCP en `mcp/logs/protocol.log`.
- Gestionar los errores de consulta y comunicarlos al cliente MCP sin terminar inesperadamente el servidor.

### Criterios de aceptación

- El MCP Server continúa ejecutándose localmente mediante `stdio` y puede ser utilizado por OpenCode.
- `get_hotels` devuelve los hoteles existentes en la persistencia local.
- `get_bookings` devuelve las reservas existentes en la persistencia local.
- `get_bookings_statistics` calcula estadísticas a partir de las reservas reales.
- Ninguna de las herramientas utiliza datos simulados.
- El MCP Server utiliza la configuración de persistencia existente en el entorno local.
- Los errores de consulta se gestionan adecuadamente y se comunican al cliente MCP sin terminar el servidor.
- Las invocaciones y sus resultados continúan registrándose en `mcp/logs/mcp.log`.
- Los mensajes del protocolo MCP continúan registrándose en `mcp/logs/protocol.log` cuando el mecanismo existente lo permita.
- OpenCode puede realizar consultas en lenguaje natural cuya respuesta requiera datos reales de la aplicación.

### Fuera de alcance

- Añadir herramientas MCP nuevas.
- Implementar `resources` MCP, transporte HTTP, autenticación o autorización específica.
- Integrar servicios o fuentes de datos externas o implementar análisis avanzado o informes.

## Notas

- Issue: #28
- El issue no tiene comentarios ni etiquetas adicionales al solicitar el inicio.
- La primera iteración dejó un servidor MCP local con transporte `stdio`, tres herramientas y logging; esta feature debe conservar ese comportamiento mientras cambia únicamente la fuente de datos.
- La aplicación Laravel ya dispone de persistencia local y modelos de hoteles y reservas; el MCP debe reutilizar la configuración existente en lugar de duplicarla.

## Histórico

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
