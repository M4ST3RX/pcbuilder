<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function ranks()
    {
        return $this->hasMany(CompanyRanks::class);
    }
}
