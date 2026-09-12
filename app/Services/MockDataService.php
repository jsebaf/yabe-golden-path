<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Support\Collection;

class MockDataService
{
    /**
     * @var Collection<int, Hotel>
     */
    private Collection $hotels;

    /**
     * @var Collection<int, RoomType>
     */
    private Collection $roomTypes;

    /**
     * @var Collection<int, HotelRoomType>
     */
    private Collection $hotelRoomTypes;

    /**
     * @var Collection<int, Booking>
     */
    private Collection $bookings;

    public function __construct()
    {
        $grandHotel = new Hotel(['name' => 'Grand Hotel', 'code' => 'GRAND']);
        $grandHotel->setAttribute('id', 1);

        $coastHotel = new Hotel(['name' => 'Coast Hotel', 'code' => 'COAST']);
        $coastHotel->setAttribute('id', 2);

        $deluxeRoom = new RoomType([
            'name' => 'Deluxe Room',
            'code' => 'DELUXE',
            'maxOccupancy' => 2,
        ]);
        $deluxeRoom->setAttribute('id', 1);

        $suiteRoom = new RoomType([
            'name' => 'Suite',
            'code' => 'SUITE',
            'maxOccupancy' => 4,
        ]);
        $suiteRoom->setAttribute('id', 2);

        $standardRoom = new RoomType([
            'name' => 'Standard Room',
            'code' => 'STANDARD',
            'maxOccupancy' => 2,
        ]);
        $standardRoom->setAttribute('id', 3);

        $grandDeluxe = new HotelRoomType([
            'hotel_id' => 1,
            'room_type_id' => 1,
            'quantity' => 20,
            'price' => 125.50,
        ]);
        $grandDeluxe->setRelation('hotel', $grandHotel);
        $grandDeluxe->setRelation('roomType', $deluxeRoom);

        $grandSuite = new HotelRoomType([
            'hotel_id' => 1,
            'room_type_id' => 2,
            'quantity' => 5,
            'price' => 220.00,
        ]);
        $grandSuite->setRelation('hotel', $grandHotel);
        $grandSuite->setRelation('roomType', $suiteRoom);

        $coastStandard = new HotelRoomType([
            'hotel_id' => 2,
            'room_type_id' => 3,
            'quantity' => 12,
            'price' => 95.00,
        ]);
        $coastStandard->setRelation('hotel', $coastHotel);
        $coastStandard->setRelation('roomType', $standardRoom);

        $this->hotels = collect([$grandHotel, $coastHotel]);
        $this->roomTypes = collect([$deluxeRoom, $suiteRoom, $standardRoom]);
        $this->hotelRoomTypes = collect([$grandDeluxe, $grandSuite, $coastStandard]);

        $grandHotel->setRelation('roomTypes', collect([$grandDeluxe, $grandSuite]));
        $coastHotel->setRelation('roomTypes', collect([$coastStandard]));
        $deluxeRoom->setRelation('hotelRoomTypes', collect([$grandDeluxe]));
        $suiteRoom->setRelation('hotelRoomTypes', collect([$grandSuite]));
        $standardRoom->setRelation('hotelRoomTypes', collect([$coastStandard]));

        $this->bookings = collect([
            new Booking([
                'locator' => 'GRA001',
                'hotel' => 'GRAND',
                'roomType' => 'DELUXE',
                'paxes' => 2,
                'checkin' => '2026-10-01',
                'checkout' => '2026-10-05',
                'status' => 'CONFIRMED',
            ]),
            new Booking([
                'locator' => 'GRA002',
                'hotel' => 'GRAND',
                'roomType' => 'DELUXE',
                'paxes' => 1,
                'checkin' => '2026-10-03',
                'checkout' => '2026-10-04',
                'status' => 'CONFIRMED',
            ]),
            new Booking([
                'locator' => 'GRA003',
                'hotel' => 'GRAND',
                'roomType' => 'SUITE',
                'paxes' => 4,
                'checkin' => '2026-10-10',
                'checkout' => '2026-10-12',
                'status' => 'CONFIRMED',
            ]),
            new Booking([
                'locator' => 'COA001',
                'hotel' => 'COAST',
                'roomType' => 'STANDARD',
                'paxes' => 2,
                'checkin' => '2026-10-02',
                'checkout' => '2026-10-06',
                'status' => 'CONFIRMED',
            ]),
            new Booking([
                'locator' => 'COA002',
                'hotel' => 'COAST',
                'roomType' => 'STANDARD',
                'paxes' => 1,
                'checkin' => '2026-10-15',
                'checkout' => '2026-10-18',
                'status' => 'CANCELLED',
            ]),
        ]);
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function hotels(): Collection
    {
        return $this->hotels;
    }

    /**
     * @return Collection<int, RoomType>
     */
    public function roomTypes(): Collection
    {
        return $this->roomTypes;
    }

    /**
     * @return Collection<int, HotelRoomType>
     */
    public function hotelRoomTypes(): Collection
    {
        return $this->hotelRoomTypes;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function bookings(): Collection
    {
        return $this->bookings;
    }
}
