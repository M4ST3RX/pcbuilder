<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function computers()
    {
        return $this->hasMany(Computer::class, 'id', 'user_id');
    }
}
