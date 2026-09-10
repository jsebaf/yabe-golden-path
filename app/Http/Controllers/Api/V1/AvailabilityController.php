<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    public function store(): JsonResponse
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
