<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HardwareType extends Model
{
    public function hardwares()
    {
        return $this->hasMany(ComputerHardware::class);
    }
}
