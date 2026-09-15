<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        Booking::create(['locator' => 'GRA001', 'hotel' => 'GRAND', 'roomType' => 'DELUXE', 'paxes' => 2, 'checkin' => '2026-10-01', 'checkout' => '2026-10-05', 'status' => 'CONFIRMED']);
        Booking::create(['locator' => 'GRA002', 'hotel' => 'GRAND', 'roomType' => 'DELUXE', 'paxes' => 1, 'checkin' => '2026-10-03', 'checkout' => '2026-10-04', 'status' => 'CONFIRMED']);
        Booking::create(['locator' => 'GRA003', 'hotel' => 'GRAND', 'roomType' => 'SUITE', 'paxes' => 4, 'checkin' => '2026-10-10', 'checkout' => '2026-10-12', 'status' => 'CONFIRMED']);
        Booking::create(['locator' => 'COA001', 'hotel' => 'COAST', 'roomType' => 'STANDARD', 'paxes' => 2, 'checkin' => '2026-10-02', 'checkout' => '2026-10-06', 'status' => 'CONFIRMED']);
        Booking::create(['locator' => 'COA002', 'hotel' => 'COAST', 'roomType' => 'STANDARD', 'paxes' => 1, 'checkin' => '2026-10-15', 'checkout' => '2026-10-18', 'status' => 'CANCELLED']);
    }
}
