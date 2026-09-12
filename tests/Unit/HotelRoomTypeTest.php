<?php

namespace Tests\Unit;

use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class HotelRoomTypeTest extends TestCase
{
    public function test_hotel_has_hotel_room_types(): void
    {
        $relation = (new Hotel)->roomTypes();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(HotelRoomType::class, $relation->getRelated());
    }

    public function test_hotel_room_type_belongs_to_hotel_and_room_type(): void
    {
        $hotelRoomType = new HotelRoomType;

        $this->assertInstanceOf(BelongsTo::class, $hotelRoomType->hotel());
        $this->assertInstanceOf(BelongsTo::class, $hotelRoomType->roomType());
        $this->assertInstanceOf(Hotel::class, $hotelRoomType->hotel()->getRelated());
        $this->assertInstanceOf(RoomType::class, $hotelRoomType->roomType()->getRelated());
    }

    public function test_room_type_has_hotel_room_types(): void
    {
        $relation = (new RoomType)->hotelRoomTypes();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(HotelRoomType::class, $relation->getRelated());
    }

    public function test_quantity_is_cast_to_an_integer(): void
    {
        $hotelRoomType = new HotelRoomType(['quantity' => '20']);

        $this->assertSame(20, $hotelRoomType->quantity);
    }

    public function test_price_is_cast_to_a_float(): void
    {
        $hotelRoomType = new HotelRoomType(['price' => '125.50']);

        $this->assertSame(125.5, $hotelRoomType->price);
    }

    public function test_hotel_room_type_serializes_a_room_type_and_quantity(): void
    {
        $roomType = new RoomType([
            'name' => 'Deluxe Room',
            'code' => 'DELUXE',
            'maxOccupancy' => 2,
        ]);
        $hotelRoomType = new HotelRoomType(['quantity' => 20, 'price' => 125.50]);
        $hotelRoomType->setRelation('roomType', $roomType);

        $hotel = new Hotel([
            'name' => 'Grand Hotel',
            'code' => 'GRAND',
        ]);
        $hotel->setRelation('roomTypes', collect([$hotelRoomType]));

        $this->assertSame([
            [
                'quantity' => 20,
                'price' => 125.5,
                'roomType' => [
                    'name' => 'Deluxe Room',
                    'code' => 'DELUXE',
                    'maxOccupancy' => 2,
                ],
            ],
        ], $hotel->toArray()['roomTypes']);
    }
}
