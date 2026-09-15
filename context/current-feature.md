# Sustituir el servicio mock por persistencia

## Objetivos

### Requisitos

- Implementar el acceso a los datos utilizando los modelos Eloquent existentes en `app/Models`.
- Mantener el contrato definido en `app/Contracts`.
- Sustituir la implementación mock actualmente utilizada por el servicio de datos.
- Utilizar las relaciones Eloquent existentes entre los modelos cuando sea necesario.
- Crear o completar las migraciones necesarias para representar en la base de datos el modelo de datos utilizado actualmente por la aplicación.
- Crear o completar los seeders necesarios para disponer de datos de prueba reproducibles.
- Mantener el contrato de los endpoints existentes.
- Eliminar la dependencia del mock en el funcionamiento normal de la aplicación.
- Adaptar los tests existentes cuando sea necesario y añadir los tests necesarios para verificar la persistencia.

### Criterios de aceptación

- La aplicación puede ejecutarse utilizando exclusivamente los datos almacenados en la base de datos.
- Los datos utilizados por los endpoints de consulta proceden de Eloquent.
- El endpoint de disponibilidad funciona utilizando los datos persistidos.
- Los datos iniciales pueden generarse mediante los seeders de Laravel.
- Los endpoints mantienen el contrato existente.
- Los tests existentes continúan pasando.
- La implementación mock deja de utilizarse en el flujo normal de la aplicación.
- La aplicación funciona correctamente utilizando SQLite en el entorno local y PostgreSQL en producción, sin cambios en la lógica de acceso a datos.

### Fuera de alcance

- No añadir nuevos endpoints.
- No modificar el contrato de la API existente.
- No añadir nuevas funcionalidades al dominio de reservas.
- No implementar todavía nuevas operaciones de escritura sobre reservas.
- No modificar el frontend.

## Notas

- Issue: #20
- La aplicación ya tiene modelos de dominio (`Hotel`, `RoomType`, `HotelRoomType`) y contratos definidos en `app/Contracts`.
- El servicio mock actual satisface el contrato; la nueva implementación Eloquent debe satisfacer el mismo contrato sin modificarlo.
- La implementación debe ser compatible con SQLite (desarrollo local) y PostgreSQL (producción); no usar características específicas de ninguno de los dos motores.
- Las migraciones y seeders deben cubrir todos los datos que actualmente provee el mock.

## Histórico

- 2026-09-12: Se implementó y verificó el endpoint `POST /api/v1/availability`, con Feature Tests, colección Postman y la PR #16.
- 2026-09-11: Se implementaron y verificaron los endpoints `GET /api/v1/hotels` y `GET /api/v1/room-types` usando el servicio mock, con Feature Tests y colección Postman; se creó la PR #12.
- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
