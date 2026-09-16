# Crear interfaz web de consulta de disponibilidad

## Objetivos

- Crear una pantalla web mínima con React y Tailwind CSS integrada en el proyecto Laravel existente, con fondo blanco y presentación sencilla.
- Permitir introducir fecha de entrada, fecha de salida, número de huéspedes y un hotel opcional mediante un selector.
- Cargar las opciones del selector de hoteles mediante `GET /api/v1/hotels` y permitir consultar sin seleccionar hotel.
- No incluir un selector de tipo de habitación.
- Enviar las consultas mediante `POST /api/v1/availability`, utilizando los nombres y formatos del contrato OpenAPI existente.
- Mostrar debajo del formulario los resultados de disponibilidad, incluyendo como mínimo hotel, tipo de habitación y precio.
- Mostrar estados de carga durante las peticiones y mensajes comprensibles para errores al cargar hoteles o consultar disponibilidad.
- Mantener sin cambios el contrato y la implementación de los endpoints existentes, y asegurar que la aplicación pueda construirse y ejecutarse con la configuración actual.

### Criterios de aceptación

- La pantalla de consulta aparece al acceder a la interfaz web.
- El selector de hoteles se carga desde `/api/v1/hotels`.
- Se puede consultar disponibilidad con o sin hotel seleccionado.
- La consulta envía correctamente las fechas, el número de huéspedes y, cuando corresponde, el código del hotel a `/api/v1/availability`.
- Los resultados del API se muestran debajo del formulario con hotel, tipo de habitación y precio.
- La interfaz informa visualmente durante las peticiones y muestra los errores al usuario.
- No se modifican los endpoints existentes ni se añaden autenticación, reservas, selección de tipo de habitación o administración.

## Notas

- Issue: #22
- La aplicación ya dispone de los endpoints funcionales para hoteles y disponibilidad; esta feature se limita a la interfaz web.
- La integración debe utilizar React y Tailwind CSS dentro del proyecto Laravel y funcionar con los datos actuales del API.
- El selector de hotel es opcional; el código del hotel solo debe incluirse en la consulta cuando el usuario lo seleccione.
- El contrato OpenAPI existente es la fuente de verdad para los nombres y formatos enviados a disponibilidad.

## Histórico

- 2026-09-15: Se sustituyó el servicio mock por persistencia Eloquent con migraciones, seeders y `EloquentDataService`; se adaptaron los tests con `RefreshDatabase`; se creó la PR #21.
- 2026-09-12: Se implementó y verificó el endpoint `POST /api/v1/availability`, con Feature Tests, colección Postman y la PR #16.
- 2026-09-11: Se implementaron y verificaron los endpoints `GET /api/v1/hotels` y `GET /api/v1/room-types` usando el servicio mock, con Feature Tests y colección Postman; se creó la PR #12.
- 2026-09-11: Se implementó y verificó el modelo conceptual de inventario con `Hotel`, `RoomType` y `HotelRoomType`, sin persistencia ni implementación de disponibilidad o bookings. La suite pasó con 8 tests y 32 assertions.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #6, "Adaptar el API al modelo de inventario de habitaciones".
- 2026-09-10: Se implementó y verificó el esqueleto inicial del API definido en el issue #4.
- 2026-09-10: Se preparó el contexto inicial a partir del issue #4, "Implementar el esqueleto del API".
- 2026-09-10: Se preparó el contexto inicial a partir del issue #1, "Inicializar el proyecto Laravel".
