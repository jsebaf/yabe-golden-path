<?php

namespace App\Contracts;

use App\Models\Booking;
use App\Models\HotelRoomType;
use Illuminate\Support\Collection;

interface AvailabilityDataSource
{
    /**
     * @return Collection<int, HotelRoomType>
     */
    public function hotelRoomTypes(): Collection;

    /**
     * @return Collection<int, Booking>
     */
    public function bookings(): Collection;
}
