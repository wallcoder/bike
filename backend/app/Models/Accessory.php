<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accessory extends Model
{
    protected $guarded = [];


    public function cartItem(): HasMany{
        return $this->hasMany(CartItem::class);
    }

    public function orderItem(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function accessoryColor(): HasMany{
        return $this->hasMany(AccessoryColor::class);
    }
    public function accessoryVariant(): HasMany{
        return $this->hasMany(AccessoryVariant::class);
    }
    


}
