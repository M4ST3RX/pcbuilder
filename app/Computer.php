<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $casts = [
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pc_brand()
    {
        return $this->belongsTo(ComputerBrand::class, 'brand');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'computer_id', 'id');
    }

    public function is_hdd()
    {
        $items = $this->items;
        $isHdd = false;
        foreach ($items as $item) {
            if($item->hardware->hardware_type->type === 'Hard Disk Drive') {
                $isHdd = true;
                break;
            }
        }

        return $isHdd;
    }

    public function video_power()
    {
        $items = $this->items;
        $power = 0;
        foreach ($items as $item) {
            print_r($item);
            if($item->hardware->hardware_type->type === 'Video Card') {
                dd($item->hardware->data);
                break;
            }
        }



        return $power;
    }
}
