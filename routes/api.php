<?php

use App\Http\Controllers\Api\V1\AvailabilityController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\HotelController;
use App\Http\Controllers\Api\V1\RoomTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/room-types', [RoomTypeController::class, 'index'])->name('room-types.index');
Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
