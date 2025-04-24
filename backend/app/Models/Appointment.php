<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $guarded = [];

    public function bike():BelongsTo{
        return $this->belongsTo(Bike::class);
    }
    public function payment():HasMany{
        return $this->hasMany(Payment::class);
    }
}

