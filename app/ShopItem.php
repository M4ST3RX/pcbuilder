<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;

    public function item_prefab() {
        return $this->belongsTo(ItemPrefab::class);
    }

    public function getPrice() {
        if($this->discount > 0) {
            return number_format($this->price * ((100 - $this->discount) / 100), 2);
        }

        return $this->price;
    }
}
