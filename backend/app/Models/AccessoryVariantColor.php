<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccessoryVariantColor extends Model
{
    protected $guarded = [];

     public function accessoryVariant(): BelongsTo{
        return $this->belongsTo( AccessoryVariant::class);
    }

    public function color(): BelongsTo{
        return $this->belongsTo(Color::class);
    }

    public function orderItem(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function cartItem(): HasMany{
        return $this->hasMany(CartItem::class);
    }
}
