<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function store(Request $request, AvailabilityService $availabilityService): JsonResponse
    {
        $criteria = $request->validate([
            'hotel' => ['sometimes', 'string'],
            'roomType' => ['sometimes', 'string'],
            'paxes' => ['required', 'integer', 'min:1'],
            'checkin' => ['required', 'date_format:Y-m-d'],
            'checkout' => ['required', 'date_format:Y-m-d', 'after:checkin'],
        ]);

        return response()->json($availabilityService->find($criteria));
    }
}
