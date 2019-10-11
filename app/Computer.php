<?php

namespace App;

use Carbon\Carbon;
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

    public function uses_hdd()
    {
        $items = Item::leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'hdd')
            ->first();
        return ($items !== null);
    }

    public function storage_size()
    {
        $storage = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'hdd')
            ->get();

        $totalSize = 0;
        foreach ($storage as $item) {
            $totalSize += json_decode($item->data)->size;
        }

        return (count($storage) > 0) ? Util::formatSizeUnits($totalSize) : 0;
    }

    public function storage_speed()
    {
        $storage = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'hdd')
            ->orWhere('computer_hardware.type', 'ssd')
            ->first();

        return ($storage) ? json_decode($storage->data)->speed : 0;
    }

    public function video_power()
    {
        $video_card = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'videocard')
            ->first();
        return ($video_card) ? Util::formatHertzUnits(json_decode($video_card->data)->speed) : 0;
    }

    public function current_mined_coins()
    {
        if($this->mine_start_time == null) return 0;

        $video_card = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'videocard')
            ->first();

        $diff = Carbon::now()->getTimestamp() - $this->mine_start_time;

        $coins = round($diff / 60, 0, PHP_ROUND_HALF_DOWN);
        if(Util::formatSize($this->ram_capacity(), 'B') <= $coins * 4096) {
            $coins = Util::formatSize($this->ram_capacity(), 'B') / 4096;
        }

        $bonus = (json_decode($video_card->data)->speed / 100) * $coins;

        return round($coins + $bonus, 0);
    }

    public function mine_speed()
    {
        if($this->mine_start_time == null) return 0;

        $video_card = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'videocard')
            ->first();

        $coins = 1;
        $bonus = json_decode($video_card->data)->speed / 100 * $coins;
        return $coins + $bonus;
    }

    public function ram_capacity()
    {
        $rams = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'ram')
            ->get();

        $totalSize = 0;
        foreach ($rams as $ram) {
            $totalSize += json_decode($ram->data)->size;
        }

        return $totalSize;
    }

    public function ram_mine_capacity()
    {
        $ram_size = $this->ram_capacity();
        $str = '';
        if($ram_size === 0) return "0B";

        $str .= Util::formatSizeUnits($ram_size);

        if(Util::formatSize($this->ram_capacity(), 'B') < $this->current_mined_coins() * 4096) {
            $current_mined_bytes = Util::formatSize($this->ram_capacity(), 'B');
        } else {
            $current_mined_bytes = $this->current_mined_coins() * 4096;
        }
        $percentage = round($current_mined_bytes * 100 / Util::formatSize($ram_size, 'B'), 2);

        $str .= ' / '. Util::formatSizeUnits($current_mined_bytes / 1024 / 1024) . ' (' . $percentage . '%)';

        return $str;
    }

    public function fully_functional()
    {
        $array = [];
        $items = Item::select('hardware_types.type')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->leftJoin('hardware_types', 'computer_hardware.hardware_type_id', '=', 'hardware_types.id')
            ->where('computer_id', $this->id)
            ->get();

        foreach ($items as $item) {
            $array[] = $item->type;
        }

        if((in_array('Hard Disk Drive', $array) || in_array('Solid State Drive', $array)) && in_array('Motherboard', $array)
            && in_array('RAM', $array) && in_array('Video Card', $array) && in_array('CPU', $array)) return true;
        return false;
    }
}
