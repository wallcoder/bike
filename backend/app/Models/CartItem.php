<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $guarded = [];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function accessory(): BelongsTo{
        return $this->belongsTo(Accessory::class);
    }
}
