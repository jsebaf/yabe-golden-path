"""Local MCP server for the booking engine demonstration."""

from __future__ import annotations

import json
import logging
import sys
from pathlib import Path
from typing import Any

from mcp.server.fastmcp import FastMCP


BASE_DIR = Path(__file__).resolve().parent
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


def record_tool_call(name: str, arguments: dict[str, Any], result: Any) -> None:
    logger.info(
        "operation=tools/call tool=%s arguments=%s result=%s",
        name,
        json.dumps(arguments, sort_keys=True),
        json.dumps(result, sort_keys=True),
    )


@mcp.tool()
def get_hotels() -> list[dict[str, Any]]:
    """Return simulated hotels available in the booking engine."""
    result = [
        {"id": 1, "name": "Hotel Yabe Madrid", "city": "Madrid"},
        {"id": 2, "name": "Hotel Yabe Barcelona", "city": "Barcelona"},
    ]
    record_tool_call("get_hotels", {}, result)
    return result


@mcp.tool()
def get_bookings() -> list[dict[str, Any]]:
    """Return simulated bookings from the booking engine."""
    result = [
        {"locator": "YABE001", "hotel": "Hotel Yabe Madrid", "status": "CONFIRMED"},
        {"locator": "YABE002", "hotel": "Hotel Yabe Barcelona", "status": "PENDING"},
    ]
    record_tool_call("get_bookings", {}, result)
    return result


@mcp.tool()
def get_bookings_statistics() -> dict[str, int]:
    """Return simulated booking statistics."""
    result = {"total": 2, "confirmed": 1, "pending": 1, "cancelled": 0}
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
