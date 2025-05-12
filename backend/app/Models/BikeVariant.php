<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BikeVariant extends Model
{
    protected $guarded = [];

    public function bike(): BelongsTo{
        return $this->belongsTo(Bike::class);
    }

    public function bikeVariantColor(): HasMany{
        return $this->hasMany(BikeVariantColor::class);
    }
}
