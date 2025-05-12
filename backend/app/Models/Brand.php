<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $guarded = [];

    public function bike(): HasMany{
        return $this->hasMany(Bike::class);
    }

    public function accessory(): HasMany{
        return $this->hasMany(Accessory::class);
    }

}
