<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BikeVariantColor extends Model
{
    protected $guarded = [];

    public function bikeVariant(): BelongsTo{
        return $this->belongsTo(BikeVariant::class);
    }

    public function color(): BelongsTo{
        return $this->belongsTo(Color::class);
    }

    public function appointment(): HasMany{
        return $this->hasMany(BikeVariantColor::class);
    }


}
