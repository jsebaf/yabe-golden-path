<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiQueryEndpointsTest extends TestCase
{
    public function test_hotels_endpoint_returns_hotels_with_room_types_and_inventory(): void
    {
        $response = $this->getJson('/api/v1/hotels');

        $response->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'code',
                    'roomTypes' => [
                        '*' => [
                            'roomType' => ['name', 'code', 'maxOccupancy'],
                            'quantity',
                        ],
                    ],
                ],
            ])
            ->assertJson([
                [
                    'name' => 'Grand Hotel',
                    'code' => 'GRAND',
                    'roomTypes' => [
                        [
                            'roomType' => [
                                'name' => 'Deluxe Room',
                                'code' => 'DELUXE',
                                'maxOccupancy' => 2,
                            ],
                            'quantity' => 20,
                        ],
                    ],
                ],
            ]);
    }

    public function test_room_types_endpoint_returns_room_types(): void
    {
        $response = $this->getJson('/api/v1/room-types');

        $response->assertOk()
            ->assertJsonStructure([
                '*' => ['name', 'code', 'maxOccupancy'],
            ])
            ->assertJson([
                [
                    'name' => 'Deluxe Room',
                    'code' => 'DELUXE',
                    'maxOccupancy' => 2,
                ],
                [
                    'name' => 'Suite',
                    'code' => 'SUITE',
                    'maxOccupancy' => 4,
                ],
                [
                    'name' => 'Standard Room',
                    'code' => 'STANDARD',
                    'maxOccupancy' => 2,
                ],
            ]);
    }
}
