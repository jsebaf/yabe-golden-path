# Implementar endpoints de consulta

## Objetivos

Implementar los endpoints de consulta del API:

- `GET /api/v1/hotels`, accesible sin autenticación, devolviendo un array conforme al esquema `Hotel` de OpenAPI.
- `GET /api/v1/room-types`, accesible sin autenticación, devolviendo un array conforme al esquema `RoomType` de OpenAPI.

Requisitos técnicos y de respuesta:

- Utilizar el servicio de datos mock existente como única fuente de datos.
- No acceder directamente a los datos mock desde los controllers.
- Incluir en cada hotel sus `HotelRoomType`, el `RoomType` asociado y la cantidad de unidades (`quantity`).
- Añadir Feature Tests para ambos endpoints que verifiquen al menos el código de respuesta y la estructura de las respuestas.
- Mantener la suite completa de tests pasando.

## Notas

Quedan fuera de alcance la persistencia, las migraciones y los seeders, la autenticación y autorización, la paginación, el filtrado y la ordenación, así como:

- `POST /api/v1/availability` y el cálculo de disponibilidad.
- `POST /api/v1/bookings`.
- Cualquier modificación de la especificación OpenAPI.

## Histórico

- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
