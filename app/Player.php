<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company_rank()
    {
        return $this->hasOne(CompanyRanks::class, 'company_rank_id', 'id');
    }
}
