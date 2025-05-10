<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $guarded = [];

    public function bikeVariantColor():BelongsTo{
        return $this->belongsTo(BikeVariantColor::class);
    }
    public function payment():HasMany{
        return $this->hasMany(Payment::class);
    }
}

