<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccessoryVariant extends Model
{
    protected $guarded = [];
    public function accessory(): BelongsTo{
        return $this->belongsTo(Accessory::class);
    }

    public function accessoryVariantColor(): HasMany{
        return $this->hasMany(AccessoryVariantColor::class);
    }

   
}
