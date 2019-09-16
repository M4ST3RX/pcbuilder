<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;

    public function hardware()
    {
        return $this->belongsTo(ComputerHardware::class, 'computer_hardware_id');
    }
}
