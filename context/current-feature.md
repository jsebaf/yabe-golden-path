# Dockerizar aplicación para ejecución local

## Objetivos

- Crear un `Dockerfile` para construir la imagen de la aplicación.
- Instalar las dependencias PHP con `composer install`.
- Instalar las dependencias JavaScript con `npm ci` y construir los assets con `npm run build`.
- Utilizar SQLite como base de datos e inicializarla mediante las migraciones y el seed de Laravel.
- Crear un `compose.yaml` que permita levantar la aplicación con un único comando.
- Exponer la aplicación en el host mediante el puerto `8000` y hacer que Laravel escuche en una interfaz accesible desde fuera del contenedor.
- Permitir eliminar y recrear el contenedor sin reconstruir manualmente el entorno.
- Gestionar de forma coherente los datos necesarios para la persistencia SQLite.
- Documentar cómo construir, arrancar, acceder, detener, eliminar y reconstruir el entorno, incluyendo la decisión sobre la persistencia de SQLite.

### Criterios de aceptación

- Desde una instalación limpia, `docker compose up --build` debe arrancar correctamente la aplicación.
- YABE debe estar disponible en `http://localhost:8000`.
- La aplicación debe disponer de la estructura de base de datos y los datos iniciales proporcionados por las migraciones y el seed de Laravel.
- Debe ser posible detener, eliminar y volver a levantar el entorno siguiendo las instrucciones documentadas.

## Notas

- Issue: #30
- El alcance es la ejecución local mediante Docker Compose, sin requerir PHP, Composer, Node.js ni dependencias instaladas en el host.
- La configuración debe poder servir como base para un futuro despliegue de la misma imagen en un VPS, pero no incluye despliegue, producción, SSH, GitHub Actions, HTTPS, PostgreSQL ni Nginx externo.
- Deben conservarse los comandos y el flujo de inicialización existentes de Laravel, adaptándolos al contenedor y a SQLite.

## Histórico

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
