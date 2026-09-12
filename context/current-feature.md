# Implementar disponibilidad

## Objetivos

Implementar el endpoint `POST /api/v1/availability` conforme al contrato OpenAPI vigente.

### Requisitos funcionales

- Aceptar un `AvailabilityRequest` y devolver un array de elementos `Availability`.
- Considerar el número de huéspedes solicitado (`paxes`) y excluir los tipos de habitación cuya capacidad (`maxOccupancy`) sea insuficiente.
- Calcular la disponibilidad usando la cantidad de unidades (`quantity`) definida en `HotelRoomType`.
- Reducir el inventario según los bookings confirmados que se solapen con el intervalo solicitado.
- Ignorar los bookings que no se solapen y los que tengan estado `CANCELLED`.
- No devolver un tipo de habitación cuando todas sus unidades estén ocupadas durante el intervalo solicitado.
- Devolver el tipo de habitación cuando exista al menos una unidad disponible.
- Obtener el `price` del `HotelRoomType` correspondiente, sin calcular tarifas.
- Permitir filtrar opcionalmente por los códigos de hotel (`hotel`) y tipo de habitación (`roomType`).
- Sin filtros, consultar todos los hoteles y tipos de habitación que cumplan los criterios solicitados.

### Solapación de intervalos

Un booking se solapa con el intervalo solicitado cuando se cumplen ambas condiciones:

- `booking.checkin < requested.checkout`
- `booking.checkout > requested.checkin`

### Verificación

- Añadir Feature Tests para disponibilidad sin bookings solapados, bookings solapados y cancelados, intervalos sin disponibilidad, capacidad insuficiente, filtros, precio e intervalos diferentes.
- Mantener pasando la suite completa de tests.

## Notas

- La lógica debe obtener los datos a través del servicio de datos existente, que actualmente usa el mock en memoria.
- La lógica de disponibilidad no debe depender de la forma concreta de almacenamiento o provisión del mock, para permitir sustituirlo posteriormente por persistencia.
- No se requiere persistencia ni modificar el servicio mock salvo lo estrictamente necesario.
- Fuera de alcance: creación o cancelación de bookings, gestión de concurrencia, cálculo dinámico de tarifas, tarifas variables, paginación, autenticación y autorización.

## Histórico

- 2026-09-11: Se implementaron y verificaron los endpoints `GET /api/v1/hotels` y `GET /api/v1/room-types` usando el servicio mock, con Feature Tests y colección Postman; se creó la PR #12.
- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
