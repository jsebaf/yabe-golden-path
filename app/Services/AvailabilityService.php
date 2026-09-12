<?php

namespace App\Services;

use App\Contracts\AvailabilityDataSource;
use Carbon\CarbonImmutable;

class AvailabilityService
{
    public function __construct(private readonly AvailabilityDataSource $dataSource) {}

    /**
     * @param  array{hotel?: string, roomType?: string, paxes: int, checkin: string, checkout: string}  $criteria
     * @return array<int, array<string, mixed>>
     */
    public function find(array $criteria): array
    {
        $checkin = CarbonImmutable::createFromFormat('!Y-m-d', $criteria['checkin']);
        $checkout = CarbonImmutable::createFromFormat('!Y-m-d', $criteria['checkout']);

        return $this->dataSource->hotelRoomTypes()
            ->filter(function ($inventory) use ($criteria): bool {
                return (! isset($criteria['hotel']) || $inventory->hotel->code === $criteria['hotel'])
                    && (! isset($criteria['roomType']) || $inventory->roomType->code === $criteria['roomType'])
                    && $inventory->roomType->maxOccupancy >= $criteria['paxes'];
            })
            ->filter(function ($inventory) use ($checkin, $checkout): bool {
                $occupied = $this->dataSource->bookings()
                    ->filter(fn ($booking): bool => $booking->status === 'CONFIRMED')
                    ->filter(fn ($booking): bool => $booking->hotel === $inventory->hotel->code)
                    ->filter(fn ($booking): bool => $booking->roomType === $inventory->roomType->code)
                    ->filter(fn ($booking): bool => $booking->checkin->lt($checkout))
                    ->filter(fn ($booking): bool => $booking->checkout->gt($checkin))
                    ->count();

                return $occupied < $inventory->quantity;
            })
            ->map(fn ($inventory): array => [
                'hotel' => [
                    'name' => $inventory->hotel->name,
                    'code' => $inventory->hotel->code,
                    'roomTypes' => [[
                        'roomType' => [
                            'name' => $inventory->roomType->name,
                            'code' => $inventory->roomType->code,
                            'maxOccupancy' => $inventory->roomType->maxOccupancy,
                        ],
                        'quantity' => $inventory->quantity,
                        'price' => $inventory->price,
                    ]],
                ],
                'roomType' => [
                    'name' => $inventory->roomType->name,
                    'code' => $inventory->roomType->code,
                    'maxOccupancy' => $inventory->roomType->maxOccupancy,
                ],
                'price' => $inventory->price,
            ])
            ->values()
            ->all();
    }
}
