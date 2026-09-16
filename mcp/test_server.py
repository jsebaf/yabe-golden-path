import sqlite3
import unittest
from pathlib import Path
from tempfile import TemporaryDirectory
from unittest.mock import patch

import sys
import importlib.util

sys.path.insert(0, str(Path(__file__).parent.parent))
spec = importlib.util.spec_from_file_location("mcp_server", Path(__file__).parent / "server.py")
server = importlib.util.module_from_spec(spec)
spec.loader.exec_module(server)


class McpDataTest(unittest.TestCase):
    def setUp(self):
        self.directory = TemporaryDirectory()
        self.database = Path(self.directory.name) / "application.sqlite"
        connection = sqlite3.connect(self.database)
        connection.executescript(
            """
            CREATE TABLE hotels (id INTEGER PRIMARY KEY, name TEXT, code TEXT);
            CREATE TABLE bookings (
                id INTEGER PRIMARY KEY, locator TEXT, hotel TEXT, roomType TEXT,
                paxes INTEGER, checkin TEXT, checkout TEXT, status TEXT
            );
            INSERT INTO hotels VALUES (1, 'Grand Hotel', 'GRAND');
            INSERT INTO bookings VALUES (1, 'GRA001', 'GRAND', 'DELUXE', 2, '2026-10-01', '2026-10-05', 'CONFIRMED');
            INSERT INTO bookings VALUES (2, 'COA001', 'COAST', 'STANDARD', 1, '2026-10-02', '2026-10-06', 'CANCELLED');
            """
        )
        connection.close()

    def tearDown(self):
        self.directory.cleanup()

    def test_tools_read_application_data(self):
        with patch.object(server, "database_path", return_value=self.database):
            self.assertEqual(server.get_hotels(), [{"id": 1, "name": "Grand Hotel", "code": "GRAND"}])
            self.assertEqual(server.get_bookings()[0]["locator"], "GRA001")
            self.assertEqual(
                server.get_bookings_statistics(),
                {"total": 2, "confirmed": 1, "pending": 0, "cancelled": 1},
            )

    def test_query_errors_are_returned_to_the_client(self):
        with patch.object(server, "database_path", return_value=Path(self.directory.name) / "missing.sqlite"):
            result = server.get_bookings()
        self.assertIn("error", result)


if __name__ == "__main__":
    unittest.main()
