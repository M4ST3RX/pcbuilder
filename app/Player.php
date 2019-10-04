<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function computers()
    {
        return $this->hasMany(Computer::class, 'user_id', 'user_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'user_id');
    }

    public function auth()
    {
        return $this->belongsTo(User::class);
    }
}
