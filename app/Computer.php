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

        $diff = Carbon::now()->getTimestamp() - $this->mine_start_time;
        if($diff <= 0) {
            $coins = ($this->ram_capacity() / 60) * 0.00001;
        } else {
            $coins = ($diff / 60) * 0.00001;
        }
        $bonus = (json_decode($video_card->data)->speed / 100) * $coins;

        return number_format(round(($coins + $bonus), 5), 5);
    }

    public function mine_speed()
    {
        if($this->mine_start_time == null) return 0;

        $video_card = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'videocard')
            ->first();

        $coins = 0.00001;
        $bonus = (json_decode($video_card->data)->speed / 100) * $coins;
        return number_format(round(($coins + $bonus), 5), 5) . ' ByteCoin / minute';
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
        $video_card = Item::select('computer_hardware.data')
            ->leftJoin('computer_hardware', 'items.computer_hardware_id', '=', 'computer_hardware.id')
            ->where('computer_id', $this->id)
            ->where('computer_hardware.type', 'videocard')
            ->first();

        $str = '';
        if($ram_size === 0) return "0B";

        $str .= Util::formatSizeUnits($ram_size);
        $diff = Carbon::now()->getTimestamp() - $this->mine_start_time;

        if(Util::formatSize($this->ram_capacity(), 'B') < $diff * 1024) {
            $coins = (Util::formatSize($this->ram_capacity(), 'B') / 60) * 0.00001;
            $bonus = (json_decode($video_card->data)->speed / 100) * $coins;
            $current_mined_bytes = $coins + $bonus;
        } else {
            $current_mined_bytes = $diff * 1024;
        }
        $percentage = round($current_mined_bytes / ((Util::formatSize($ram_size, 'B')) / 100), 2);

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
