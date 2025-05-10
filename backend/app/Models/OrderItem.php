<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $guarded = [];

    

    public function accessoryVariantColor(): BelongsTo{
        return $this->belongsTo(AccessoryVariantColor::class);
    }

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
