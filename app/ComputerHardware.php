<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComputerHardware extends Model
{
    public function hardware_type()
    {
        return $this->belongsTo(HardwareType::class);
    }
}
