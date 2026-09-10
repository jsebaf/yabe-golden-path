<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'code', 'maxOccupancy'])]
class RoomType extends Model
{
    public static $snakeAttributes = false;

    /**
     * Get the hotel inventory entries for this room type.
     */
    public function hotelRoomTypes(): HasMany
    {
        return $this->hasMany(HotelRoomType::class);
    }
}
