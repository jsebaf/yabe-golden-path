<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $deluxe = RoomType::create(['name' => 'Deluxe Room', 'code' => 'DELUXE', 'maxOccupancy' => 2]);
        $suite = RoomType::create(['name' => 'Suite', 'code' => 'SUITE', 'maxOccupancy' => 4]);
        $standard = RoomType::create(['name' => 'Standard Room', 'code' => 'STANDARD', 'maxOccupancy' => 2]);

        $grand = Hotel::create(['name' => 'Grand Hotel', 'code' => 'GRAND']);
        $coast = Hotel::create(['name' => 'Coast Hotel', 'code' => 'COAST']);

        HotelRoomType::create(['hotel_id' => $grand->id, 'room_type_id' => $deluxe->id, 'quantity' => 20, 'price' => 125.50]);
        HotelRoomType::create(['hotel_id' => $grand->id, 'room_type_id' => $suite->id, 'quantity' => 5, 'price' => 220.00]);
        HotelRoomType::create(['hotel_id' => $coast->id, 'room_type_id' => $standard->id, 'quantity' => 12, 'price' => 95.00]);
    }
}
