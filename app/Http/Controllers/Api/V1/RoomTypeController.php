<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\JsonResponse;

class RoomTypeController extends Controller
{
    public function index(): JsonResponse
    {
        $roomTypes = RoomType::all()->map(fn (RoomType $roomType): array => [
            'name' => $roomType->name,
            'code' => $roomType->code,
            'maxOccupancy' => $roomType->maxOccupancy,
        ])->values()->all();

        return response()->json($roomTypes);
    }
}
