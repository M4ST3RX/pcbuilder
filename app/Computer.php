<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Computer extends Model
{
    public $slots = [
        [
            'row' => 1,
            'slots' => [
                ['type' => '1'],
                ['type' => '2'],
                ['type' => '3'],
                ['type' => '3'],
                ['type' => '4'],
                ['type' => '4'],
                ['type' => '4'],
                ['type' => '4']
            ]
        ],
        [
            'row' => 2,
            'slots' => [
                ['type' => '6'],
                ['type' => '5'],
                ['type' => '5'],
                ['type' => '5'],
                ['type' => '5'],
                ['type' => '-1'],
                ['type' => '-1'],
                ['type' => '-1']
            ]
        ]
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->hasOne(CryptoWallet::class, 'id', 'crypto_wallet_id');
    }

    public function canPlaceItem($item_id, $slot) {
        $item = Item::find($item_id);

        return $item->prefab->type === Util::computerSlotToType($slot);
    }

    public function storage_size($display = false)
    {
        $storageSize = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->prefab->type == 4) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['size'])) continue;
                $storageSize += $item_data['size'] * ($item_data['quality'] / 100);
            }
        }

        return $display ? Util::formatSizeUnits($storageSize) : $storageSize;
    }

    public function storage_speed($display = false)
    {
        $storageSpeed = 0;
        $numberOfStorage = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->prefab->type == 4) {
                $numberOfStorage++;
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['speed'])) continue;
                $storageSpeed += $item_data['speed'];
            }
        }

        $storageSpeed = $numberOfStorage > 0 ? $storageSpeed / $numberOfStorage : $storageSpeed;

        return $display ? Util::formatSizeUnits($storageSpeed) . "/s" : $storageSpeed;
    }

    public function gpu_speed($display = false)
    {
        $hash_rate = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->prefab->type == 3) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['attributes']['hash_rate'])) continue;
                $hash_rate += $item_data['attributes']['hash_rate'];
            }
        }

        return $display ? Util::formatSizeUnits($hash_rate) : $hash_rate;
    }

    /**
     * Calculate mined blocks over a period of time
     */
    public function current_mined_blocks($mine_id)
    {
        if($this->mine_start_time == null) return 0;

        $mine = Mine::find($mine_id);

        $diff = Carbon::now()->getTimestamp() - Carbon::createFromFormat('Y-m-d H:i:s', $this->mine_start_time)->getTimestamp();
        //$ram_capacity = $this->ram_capacity();
        $mined_blocks = $this->gpu_speed() * $diff / (135000 * $mine->difficulty_level);

        /*if($mined_coins * $mine->memory_conversion >= $ram_capacity) {
            $mined_coins = $ram_capacity;
        }*/

        return floor($mined_blocks);
    }

    /**
     * Calculate mine speed per second
     */
    public function mine_speed($mine_id)
    {
        $hash_rate = 0;
        $num_of_gpu = 0;

        $mine = Mine::find($mine_id);
        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->prefab->type == 3) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['attributes']['hash_rate'])) continue;
                $hash_rate += $item_data['attributes']['hash_rate'];
                $num_of_gpu++;
            }
        }

        //$hash_rate = $hash_rate / $num_of_gpu;

        return ($hash_rate * 60) / (135000 * $mine->difficulty_level);



        return ((($mine->block_reward * 60) / $mine->difficulty_level) / 6480000) * $hash_rate / 60;
    }

    public function ram_capacity()
    {
        $totalSize = 0;
        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();
        foreach($items as $item) {
            if ($item->prefab->type == 5) {
                $item_data = json_decode($item->data, true);
                if(!isset($item_data['attributes']['size'])) continue;
                $totalSize += $item_data['attributes']['size'];
            }
        }

        return $totalSize;
    }

    public function ram_mine_capacity($mine_id)
    {
        $ram_size = $this->ram_capacity();
        $mine = Mine::find($mine_id);

        $mined_blocks = $this->current_mined_blocks($mine_id);
        $current_mined_bytes = $mined_blocks * $mine->memory_conversion * 20;
        $percentage = $ram_size === 0 ? 0 : round($current_mined_bytes * 100 / $ram_size, 2);

        return Util::formatSizeUnits($current_mined_bytes) . ' / ' . Util::formatSizeUnits($ram_size) . ' (' . $percentage . '%)';
    }

    public function isComplete()
    {
        $items = Item::where('computer_id', $this->id)->where('in_computer', true)->get();
        $array = [];

        foreach ($items as $item) {
            $array[] = $item->prefab->type;
        }

        if((in_array(1, $array) && in_array(2, $array)) && in_array(3, $array) && in_array(4, $array) && in_array(5, $array) && in_array(6, $array)) return true;
        return false;
    }
}
