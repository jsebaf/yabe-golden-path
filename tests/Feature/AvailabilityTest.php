<?php

namespace Tests\Feature;

use App\Contracts\AvailabilityDataSource;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\HotelRoomType;
use App\Models\RoomType;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class AvailabilityTest extends TestCase
{
    public function test_availability_returns_rooms_without_overlapping_bookings(): void
    {
        $response = $this->postJson('/api/v1/availability', [
            'paxes' => 2,
            'checkin' => '2026-10-20',
            'checkout' => '2026-10-25',
        ]);

        $response->assertOk()
            ->assertJsonCount(3)
            ->assertJsonFragment(['code' => 'GRAND'])
            ->assertJsonFragment(['code' => 'DELUXE'])
            ->assertJsonFragment(['price' => 125.5]);
    }

    public function test_overlapping_confirmed_bookings_consume_inventory(): void
    {
        $this->useFixture(2, [
            $this->booking('TEST001', '2026-10-01', '2026-10-05'),
            $this->booking('TEST002', '2026-10-03', '2026-10-04'),
        ]);

        $this->postJson('/api/v1/availability', $this->request())
            ->assertOk()
            ->assertExactJson([]);
    }

    public function test_non_overlapping_bookings_do_not_consume_inventory(): void
    {
        $this->useFixture(1, [
            $this->booking('TEST001', '2026-10-01', '2026-10-02'),
        ]);

        $this->postJson('/api/v1/availability', $this->request())
            ->assertOk()
            ->assertJsonCount(1);
    }

    public function test_cancelled_bookings_do_not_consume_inventory(): void
    {
        $this->useFixture(1, [
            $this->booking('TEST001', '2026-10-02', '2026-10-04', 'CANCELLED'),
        ]);

        $this->postJson('/api/v1/availability', $this->request())
            ->assertOk()
            ->assertJsonCount(1);
    }

    public function test_room_capacity_must_fit_requested_paxes(): void
    {
        $this->postJson('/api/v1/availability', [
            'paxes' => 5,
            'checkin' => '2026-10-20',
            'checkout' => '2026-10-25',
        ])->assertOk()->assertExactJson([]);
    }

    public function test_hotel_and_room_type_filters_limit_results(): void
    {
        $this->postJson('/api/v1/availability', [
            'hotel' => 'GRAND',
            'roomType' => 'SUITE',
            'paxes' => 4,
            'checkin' => '2026-10-20',
            'checkout' => '2026-10-25',
        ])->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['code' => 'GRAND'])
            ->assertJsonFragment(['code' => 'SUITE'])
            ->assertJsonFragment(['price' => 220]);
    }

    public function test_availability_changes_when_requested_interval_changes(): void
    {
        $this->useFixture(1, [
            $this->booking('TEST001', '2026-10-02', '2026-10-04'),
        ]);

        $this->postJson('/api/v1/availability', [
            ...$this->request(),
            'checkin' => '2026-10-01',
            'checkout' => '2026-10-02',
        ])->assertOk()->assertJsonCount(1);

        $this->postJson('/api/v1/availability', $this->request())
            ->assertOk()
            ->assertExactJson([]);
    }

    public function test_availability_request_requires_a_valid_interval(): void
    {
        $this->postJson('/api/v1/availability', [
            'paxes' => 2,
            'checkin' => '2026-10-05',
            'checkout' => '2026-10-01',
        ])->assertUnprocessable();
    }

    private function request(): array
    {
        return [
            'paxes' => 2,
            'checkin' => '2026-10-02',
            'checkout' => '2026-10-04',
        ];
    }

    private function booking(string $locator, string $checkin, string $checkout, string $status = 'CONFIRMED'): Booking
    {
        return new Booking([
            'locator' => $locator,
            'hotel' => 'TEST',
            'roomType' => 'STANDARD',
            'paxes' => 2,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'status' => $status,
        ]);
    }

    /**
     * @param  array<int, Booking>  $bookings
     */
    private function useFixture(int $quantity, array $bookings, int $maxOccupancy = 2): void
    {
        $hotel = new Hotel(['name' => 'Test Hotel', 'code' => 'TEST']);
        $roomType = new RoomType([
            'name' => 'Standard Room',
            'code' => 'STANDARD',
            'maxOccupancy' => $maxOccupancy,
        ]);
        $inventory = new HotelRoomType([
            'quantity' => $quantity,
            'price' => 100,
        ]);
        $inventory->setRelation('hotel', $hotel);
        $inventory->setRelation('roomType', $roomType);

        $dataSource = Mockery::mock(AvailabilityDataSource::class);
        $dataSource->shouldReceive('hotelRoomTypes')->andReturn(new Collection([$inventory]));
        $dataSource->shouldReceive('bookings')->andReturn(new Collection($bookings));

        $this->app->instance(AvailabilityDataSource::class, $dataSource);
    }
}
