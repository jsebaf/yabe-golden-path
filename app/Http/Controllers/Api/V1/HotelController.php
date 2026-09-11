<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MockDataService;
use Illuminate\Http\JsonResponse;

class HotelController extends Controller
{
    public function index(MockDataService $mockDataService): JsonResponse
    {
        $hotels = $mockDataService->hotels()->map(function ($hotel): array {
            return [
                'name' => $hotel->name,
                'code' => $hotel->code,
                'roomTypes' => $hotel->roomTypes->map(function ($hotelRoomType): array {
                    return [
                        'roomType' => [
                            'name' => $hotelRoomType->roomType->name,
                            'code' => $hotelRoomType->roomType->code,
                            'maxOccupancy' => $hotelRoomType->roomType->maxOccupancy,
                        ],
                        'quantity' => $hotelRoomType->quantity,
                    ];
                })->values()->all(),
            ];
        })->values()->all();

        return response()->json($hotels);
    }
}
