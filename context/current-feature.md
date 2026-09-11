# Preparar servicio de datos mock

## Objetivos

Implementar un pequeño servicio que proporcione datos mock en memoria para permitir la implementación y prueba de los endpoints del API sin necesidad de persistencia.

El servicio deberá encapsular los datos mock y proporcionar acceso a:

- Hoteles.
- Tipos de habitación.
- Relación entre hoteles y tipos de habitación, incluyendo la cantidad de unidades disponibles.
- Bookings.

Los datos deberán ser coherentes entre sí y utilizar los modelos Eloquent existentes (`Hotel`, `RoomType`, `HotelRoomType` y `Booking`).

El servicio será utilizado posteriormente por la implementación de los endpoints y deberá mantener los controllers independientes de la estructura concreta de los datos mock.

### Criterios de aceptación

- Existe un servicio dedicado a proporcionar los datos mock.
- Los datos mock están encapsulados en el servicio y no están definidos directamente en los controllers.
- El servicio proporciona hoteles, room types, relaciones `HotelRoomType` y bookings.
- Los datos incluyen suficiente variedad para poder probar posteriormente los distintos endpoints del API.
- Las relaciones entre hoteles, room types y bookings son coherentes.
- Los `HotelRoomType` incluyen una cantidad de unidades para cada tipo de habitación.
- Existen bookings con distintos hoteles, room types y fechas, de forma que posteriormente puedan utilizarse para probar el cálculo de disponibilidad.
- Los datos se mantienen en memoria y no requieren base de datos.
- Los modelos Eloquent existentes se utilizan para representar los datos mock.
- La suite de tests existente continúa pasando.

## Notas

No se implementará persistencia ni lógica de negocio en esta tarea.

### Fuera de alcance

- Persistencia en base de datos.
- Migraciones y seeders.
- Implementación de los endpoints del API.
- Cálculo de disponibilidad.
- Creación o cancelación de bookings mediante el API.
- Control de concurrencia.
- Modificación del contrato OpenAPI.

## Histórico

- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
