<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BikeVariant extends Model
{
    protected $guarded = [];

    public function bike(): BelongsTo{
        return $this->belongsTo(Bike::class);
    }
}
