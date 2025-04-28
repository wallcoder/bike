<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bike extends Model
{
    protected $guarded = [];


    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }

    public function appointment(): HasMany{
        return $this->hasMany(Appointment::class);
    }
    public function bikeColor(): HasMany{
        return $this->hasMany(BikeColor::class);
    }
    

}
