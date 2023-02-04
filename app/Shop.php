<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function items() {
        return $this->hasMany(ShopItem::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}
