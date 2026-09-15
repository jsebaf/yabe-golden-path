<?php

namespace App\Services;

use App\Contracts\AvailabilityDataSource;
use App\Models\Booking;
use App\Models\HotelRoomType;
use Illuminate\Support\Collection;

class EloquentDataService implements AvailabilityDataSource
{
    public function hotelRoomTypes(): Collection
    {
        return HotelRoomType::with(['hotel', 'roomType'])->get();
    }

    public function bookings(): Collection
    {
        return Booking::all();
    }
}
