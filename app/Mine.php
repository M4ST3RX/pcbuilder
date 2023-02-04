<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mine extends Model
{
    use HasFactory;

    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}
