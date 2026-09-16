"""Local MCP server for the booking engine demonstration."""

from __future__ import annotations

import json
import logging
import os
import sqlite3
import sys
from pathlib import Path
from typing import Any

from mcp.server.fastmcp import FastMCP


BASE_DIR = Path(__file__).resolve().parent
APP_DIR = BASE_DIR.parent
LOG_DIR = BASE_DIR / "logs"
MCP_LOG = LOG_DIR / "mcp.log"
PROTOCOL_LOG = LOG_DIR / "protocol.log"

LOG_DIR.mkdir(parents=True, exist_ok=True)


def configure_logging() -> logging.Logger:
    logger = logging.getLogger("yabe-mcp")
    logger.setLevel(logging.INFO)
    logger.handlers.clear()

    formatter = logging.Formatter("%(asctime)s %(levelname)s %(message)s")
    file_handler = logging.FileHandler(MCP_LOG, encoding="utf-8")
    file_handler.setFormatter(formatter)
    logger.addHandler(file_handler)

    protocol_handler = logging.FileHandler(PROTOCOL_LOG, encoding="utf-8")
    protocol_handler.setFormatter(formatter)
    protocol_logger = logging.getLogger("yabe-mcp.protocol")
    protocol_logger.setLevel(logging.INFO)
    protocol_logger.handlers.clear()
    protocol_logger.addHandler(protocol_handler)
    protocol_logger.propagate = False
    return logger


logger = configure_logging()
protocol_logger = logging.getLogger("yabe-mcp.protocol")
mcp = FastMCP("Yabe Booking Engine")


def load_environment() -> dict[str, str]:
    """Load the Laravel environment values needed by the read-only adapter."""
    environment = dict(os.environ)
    env_file = APP_DIR / ".env"
    if not env_file.exists():
        return environment

    for line in env_file.read_text(encoding="utf-8").splitlines():
        line = line.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        key, value = line.split("=", 1)
        environment.setdefault(key, value.strip().strip('"').strip("'"))
    return environment


def database_path() -> Path:
    environment = load_environment()
    database = environment.get("DB_DATABASE", "database/database.sqlite")
    if database.startswith("sqlite:"):
        database = database.removeprefix("sqlite:")
    path = Path(database)
    return path if path.is_absolute() else APP_DIR / path


def query_rows(query: str) -> list[dict[str, Any]]:
    connection = sqlite3.connect(database_path())
    connection.row_factory = sqlite3.Row
    try:
        return [dict(row) for row in connection.execute(query).fetchall()]
    finally:
        connection.close()


def run_tool(name: str, query: str) -> Any:
    try:
        result = query_rows(query)
    except Exception as error:
        logger.exception("operation=tools/call tool=%s error=%s", name, error)
        return {"error": f"Unable to query application data: {error}"}

    record_tool_call(name, {}, result)
    return result


def record_tool_call(name: str, arguments: dict[str, Any], result: Any) -> None:
    logger.info(
        "operation=tools/call tool=%s arguments=%s result=%s",
        name,
        json.dumps(arguments, sort_keys=True),
        json.dumps(result, sort_keys=True),
    )


@mcp.tool()
def get_hotels() -> list[dict[str, Any]]:
    """Return hotels stored in the application's local persistence."""
    return run_tool("get_hotels", "SELECT id, name, code FROM hotels ORDER BY id")


@mcp.tool()
def get_bookings() -> list[dict[str, Any]]:
    """Return bookings stored in the application's local persistence."""
    return run_tool(
        "get_bookings",
        "SELECT locator, hotel, roomType, paxes, checkin, checkout, status "
        "FROM bookings ORDER BY id",
    )


@mcp.tool()
def get_bookings_statistics() -> dict[str, int]:
    """Return statistics calculated from bookings in local persistence."""
    try:
        result = query_rows(
            "SELECT COUNT(*) AS total, "
            "SUM(CASE WHEN status = 'CONFIRMED' THEN 1 ELSE 0 END) AS confirmed, "
            "SUM(CASE WHEN status = 'PENDING' THEN 1 ELSE 0 END) AS pending, "
            "SUM(CASE WHEN status = 'CANCELLED' THEN 1 ELSE 0 END) AS cancelled "
            "FROM bookings"
        )[0]
        result = {key: int(value or 0) for key, value in result.items()}
    except Exception as error:
        logger.exception("operation=tools/call tool=get_bookings_statistics error=%s", error)
        return {"error": f"Unable to query application data: {error}"}

    record_tool_call("get_bookings_statistics", {}, result)
    return result


def main() -> None:
    protocol_logger.info("server_start transport=stdio")
    logger.info("operation=server_start transport=stdio")
    # The SDK emits protocol diagnostics through its logger; keep them in the
    # protocol file instead of allowing them to pollute stdout.
    sdk_logger = logging.getLogger("mcp.server.lowlevel.server")
    sdk_logger.setLevel(logging.INFO)
    sdk_logger.handlers.clear()
    sdk_logger.addHandler(protocol_logger.handlers[0])
    sdk_logger.propagate = False
    mcp.run(transport="stdio")


if __name__ == "__main__":
    main()
