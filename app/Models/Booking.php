<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['locator', 'hotel', 'roomType', 'paxes', 'checkin', 'checkout', 'status'])]
class Booking extends Model
{
    public static $snakeAttributes = false;

    /**
     * Get the model attribute casts.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'paxes' => 'integer',
            'checkin' => 'date:Y-m-d',
            'checkout' => 'date:Y-m-d',
        ];
    }
}
