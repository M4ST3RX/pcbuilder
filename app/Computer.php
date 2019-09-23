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

        return ($storage) ? Util::formatSizeUnits($totalSize) : 0;
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

        $coins = (Carbon::now()->getTimestamp() - $this->mine_start_time) / 1e5;
        $bonus = (json_decode($video_card->data)->speed / 100) * $coins;
        return round($coins + $bonus , 4);
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
        $bonus = (json_decode($video_card->data)->speed / 100) * $coins;
        return ($coins + $bonus) / 1e4 . ' ByteCoin / second';
    }

    public function ram_mine_capacity()
    {
        $rams = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'ram')
            ->get();

        $totalSize = 0;
        $str = '';

        foreach ($rams as $ram) {
            $totalSize += json_decode($ram->data)->size;
        }

        if($totalSize === 0) return "0B";

        $str .= Util::formatSizeUnits($totalSize);

        $current_mined_bytes = $this->current_mined_coins() * 8e5;
        $percentage = round($current_mined_bytes / (($totalSize * 1024 * 1024) / 100), 2);

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
