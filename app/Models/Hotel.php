<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'code'])]
class Hotel extends Model
{
    public static $snakeAttributes = false;

    /**
     * Get the room types available at the hotel and their inventory.
     */
    public function roomTypes(): HasMany
    {
        return $this->hasMany(HotelRoomType::class);
    }
}
