# Implementar base de servidor MCP local

## Objetivos

- Crear un servidor MCP local en Python dentro de `mcp/` usando el SDK oficial de MCP para Python.
- Permitir que OpenCode lo inicie y conecte mediante `stdio`.
- Exponer las herramientas `get_hotels`, `get_bookings` y `get_bookings_statistics`.
- Permitir el descubrimiento mediante `tools/list` y la invocación mediante `tools/call`, devolviendo una respuesta válida.
- Usar resultados simulados sin acceder a la persistencia ni implementar lógica real de reservas.
- Crear `mcp/logs/` con `mcp.log` para registrar operaciones MCP, herramientas, argumentos y resultados.
- Registrar en `mcp/logs/protocol.log` los mensajes JSON-RPC de `stdio` cuando técnicamente sea posible.
- Asegurar que el logging no escriba diagnósticos en `stdout` ni interfiera con la comunicación MCP.
- Documentar en el proyecto la configuración, ejecución y conexión del servidor con OpenCode.

### Criterios de aceptación

- Existe un servidor MCP funcional en Python dentro de `mcp/` y usa el SDK oficial.
- OpenCode puede iniciarlo, conectarse, descubrir sus herramientas mediante `tools/list` e invocar al menos una mediante `tools/call`.
- Están disponibles `get_hotels`, `get_bookings` y `get_bookings_statistics`.
- Las herramientas usan datos simulados y no acceden a la persistencia de la aplicación.
- Existen `mcp/logs/`, `mcp.log` y `protocol.log` según las posibilidades técnicas de captura del protocolo.
- `mcp.log` identifica operaciones, herramientas, argumentos y resultados.
- El logging no altera ni interrumpe la comunicación MCP.
- La configuración y las instrucciones de uso están documentadas en el proyecto.

## Notas

- Issue: #25
- La primera versión queda limitada a un servidor MCP local por `stdio`; quedan fuera de alcance el transporte HTTP, los recursos MCP, autenticación, persistencia, consultas reales y lógica de negocio de reservas.
- Los logs deben escribirse fuera de `stdout`, que queda reservado para la comunicación MCP.
- Las herramientas pueden devolver datos simulados; no se requiere integrar el servidor con Laravel ni con la base de datos.

## Histórico

- 2026-09-16: Se implementó y verificó la interfaz React con Tailwind para consultar disponibilidad, se publicó en la PR #23 y esta fue fusionada.
- 2026-09-15: Se sustituyó el servicio mock por persistencia Eloquent con migraciones, seeders y `EloquentDataService`; se adaptaron los tests con `RefreshDatabase`; se creó la PR #21.
- 2026-09-12: Se implementó y verificó el endpoint `POST /api/v1/availability`, con Feature Tests, colección Postman y la PR #16.
- 2026-09-11: Se implementaron y verificaron los endpoints `GET /api/v1/hotels` y `GET /api/v1/room-types` usando el servicio mock, con Feature Tests y colección Postman; se creó la PR #12.
- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
