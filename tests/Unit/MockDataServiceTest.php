<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use App\Services\MockDataService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class MockDataServiceTest extends TestCase
{
    public function test_service_is_registered_as_a_singleton(): void
    {
        $service = app(MockDataService::class);

        $this->assertSame($service, app(MockDataService::class));
    }

    public function test_service_provides_all_mock_models_in_memory(): void
    {
        $service = app(MockDataService::class);

        $this->assertInstanceOf(Collection::class, $service->hotels());
        $this->assertInstanceOf(Collection::class, $service->roomTypes());
        $this->assertInstanceOf(Collection::class, $service->hotelRoomTypes());
        $this->assertInstanceOf(Collection::class, $service->bookings());

        $this->assertContainsOnlyInstancesOf(Hotel::class, $service->hotels());
        $this->assertContainsOnlyInstancesOf(RoomType::class, $service->roomTypes());
        $this->assertContainsOnlyInstancesOf(HotelRoomType::class, $service->hotelRoomTypes());
        $this->assertContainsOnlyInstancesOf(Booking::class, $service->bookings());

        $this->assertCount(2, $service->hotels());
        $this->assertCount(3, $service->roomTypes());
        $this->assertCount(3, $service->hotelRoomTypes());
        $this->assertCount(5, $service->bookings());
    }

    public function test_inventory_relationships_are_coherent(): void
    {
        $service = app(MockDataService::class);
        $hotels = $service->hotels()->keyBy('code');
        $roomTypes = $service->roomTypes()->keyBy('code');

        foreach ($service->hotelRoomTypes() as $inventory) {
            $this->assertGreaterThan(0, $inventory->quantity);
            $this->assertGreaterThanOrEqual(0, $inventory->price);
            $this->assertSame($inventory->hotel_id, $inventory->hotel->id);
            $this->assertSame($inventory->room_type_id, $inventory->roomType->id);
            $this->assertSame($inventory, $hotels[$inventory->hotel->code]->roomTypes
                ->firstWhere('room_type_id', $inventory->room_type_id));
            $this->assertSame($inventory, $roomTypes[$inventory->roomType->code]->hotelRoomTypes
                ->firstWhere('hotel_id', $inventory->hotel_id));
        }
    }

    public function test_bookings_reference_available_inventory_and_have_varied_dates(): void
    {
        $service = app(MockDataService::class);
        $inventory = $service->hotelRoomTypes()
            ->mapWithKeys(fn (HotelRoomType $entry): array => [
                $entry->hotel->code.':'.$entry->roomType->code => true,
            ]);

        foreach ($service->bookings() as $booking) {
            $this->assertArrayHasKey($booking->hotel.':'.$booking->roomType, $inventory->all());
            $this->assertNotEmpty($booking->checkin);
            $this->assertNotEmpty($booking->checkout);
            $this->assertLessThan($booking->checkout, $booking->checkin);
            $this->assertFalse($booking->exists);
        }

        $this->assertSame(['CANCELLED', 'CONFIRMED'], $service->bookings()
            ->pluck('status')
            ->unique()
            ->sort()
            ->values()
            ->all());
        $this->assertGreaterThan(1, $service->bookings()->pluck('hotel')->unique()->count());
        $this->assertGreaterThan(1, $service->bookings()->pluck('roomType')->unique()->count());
    }
}
