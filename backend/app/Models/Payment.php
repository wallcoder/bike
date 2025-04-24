<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $guarded = [];

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }

    public function appointment(): BelongsTo{
        return $this->belongsTo(Appointment::class);
    }

    
}
