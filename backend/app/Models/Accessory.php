<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class Accessory extends Model
{
    protected $guarded = [];


   

   
    public function accessoryVariant(): HasMany{
        return $this->hasMany(AccessoryVariant::class);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }
    
      protected static function booted()
{
    static::creating(function ($model) {
        if (empty($model->slug)) {
            $slugBase = Str::slug($model->model);
            $random = Str::random(5); // random 5-character string
            $model->slug = "{$slugBase}-{$random}";
        }
    });
}

}
