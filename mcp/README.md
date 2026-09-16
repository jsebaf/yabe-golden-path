# Servidor MCP local

Este directorio contiene un servidor local del Model Context Protocol para el motor de reservas. Solo utiliza datos simulados y no accede a la aplicación Laravel ni a su persistencia.

## Instalación

Crea un entorno virtual e instala el SDK oficial de Python:

```bash
python -m venv .venv
. .venv/bin/activate
python -m pip install -r mcp/requirements.txt
```

## Ejecución

El servidor se comunica exclusivamente mediante `stdio`. No escribas mensajes de diagnóstico en la salida estándar.

```bash
python mcp/server.py
```

Configuración MCP de OpenCode:

```json
{
  "mcp": {
    "yabe-booking": {
      "type": "local",
      "command": [".venv-mcp/bin/python", "mcp/server.py"]
    }
  }
}
```

Usa rutas absolutas para `server.py` si OpenCode se inicia desde otro directorio de trabajo.

## Herramientas

- `get_hotels`: devuelve hoteles simulados.
- `get_bookings`: devuelve reservas simuladas.
- `get_bookings_statistics`: devuelve estadísticas simuladas de reservas.

## Logs

- `mcp/logs/mcp.log` registra las operaciones del servidor, herramientas, argumentos y resultados.
- `mcp/logs/protocol.log` registra eventos del ciclo de vida del protocolo. El SDK de MCP gestiona el encuadre JSON-RPC de `stdio`, por lo que la aplicación nunca escribe diagnósticos en `stdout`.

## Diagnóstico

Comprueba que OpenCode usa el mismo Python en el que está instalado `mcp`:

```bash
.venv-mcp/bin/python -c "import mcp; print(mcp.__file__)"
opencode mcp list
```

El servidor debe aparecer conectado y sin el error `Connection closed`.
