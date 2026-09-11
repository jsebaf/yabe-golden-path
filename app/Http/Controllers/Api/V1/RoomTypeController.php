<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MockDataService;
use Illuminate\Http\JsonResponse;

class RoomTypeController extends Controller
{
    public function index(MockDataService $mockDataService): JsonResponse
    {
        $roomTypes = $mockDataService->roomTypes()->map(fn ($roomType): array => [
            'name' => $roomType->name,
            'code' => $roomType->code,
            'maxOccupancy' => $roomType->maxOccupancy,
        ])->values()->all();

        return response()->json($roomTypes);
    }
}
