<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $guarded = [];

    public function bikeVariantColor(): HasMany{
        return $this->hasMany(BikeVariantColor::class);
    }

    public function accessoryVariantColor(): HasMany{
        return $this->hasMany(AccessoryVariantColor::class);
    }
}
