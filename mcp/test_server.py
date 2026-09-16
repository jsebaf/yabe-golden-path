"""Protocol smoke test for the local MCP server."""

import asyncio
import sys
from pathlib import Path

from mcp import ClientSession, StdioServerParameters
from mcp.client.stdio import stdio_client


async def main() -> None:
    root = Path(__file__).resolve().parent.parent
    server = StdioServerParameters(
        command=sys.executable,
        args=[str(root / "mcp" / "server.py")],
    )

    async with stdio_client(server) as (read_stream, write_stream):
        async with ClientSession(read_stream, write_stream) as session:
            await session.initialize()
            tools = await session.list_tools()
            names = {tool.name for tool in tools.tools}
            expected = {"get_hotels", "get_bookings", "get_bookings_statistics"}
            assert expected <= names
            result = await session.call_tool("get_hotels", {})
            assert result.content


if __name__ == "__main__":
    asyncio.run(main())
