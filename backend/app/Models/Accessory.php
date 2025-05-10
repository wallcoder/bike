<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accessory extends Model
{
    protected $guarded = [];


   

   
    public function accessoryVariant(): HasMany{
        return $this->hasMany(AccessoryVariant::class);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }
    


}
