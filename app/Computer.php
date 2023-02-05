<?php

namespace App;

use App\Enums\ItemType;
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

        return $item->type === Util::computerSlotToType($slot);
    }

    public function storage_size($display = false)
    {
        $storageSize = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->type == ItemType::HARD_DRIVE) {
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
            if ($item->type == ItemType::HARD_DRIVE) {
                $numberOfStorage++;
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['speed'])) continue;
                $storageSpeed += $item_data['speed'];
            }
        }

        $storageSpeed = $numberOfStorage > 0 ? $storageSpeed / $numberOfStorage : $storageSpeed;

        return $display ? Util::formatSizeUnits($storageSpeed) . "/s" : $storageSpeed;
    }

    public function getGraphicsCardCapacity($display = false)
    {
        $hash_rate = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->type == ItemType::GRAPHICS_CARD) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['attributes']['hash_rate'])) continue;
                $hash_rate += $item_data['attributes']['hash_rate'] * $item->overclock_value;
            }
        }

        return $display ? Util::formatSizeUnits($hash_rate) : $hash_rate;
    }

    public function getMemoryCapacity($display = false)
    {
        $speed = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->type == ItemType::MEMORY) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['attributes']['memory_speed'])) continue;
                $speed += $item_data['attributes']['memory_speed'] * $item->overclock_value;
            }
        }

        return $display ? Util::formatSizeUnits($speed) : $speed;
    }

    public function getStorageCapacity($display = false)
    {
        $speed = 0;

        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();

        foreach ($items as $item) {
            if ($item->type == ItemType::HARD_DRIVE) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['attributes']['disk_speed'])) continue;
                $speed += $item_data['attributes']['disk_speed'];
            }
        }

        return $display ? Util::formatSizeUnits($speed) : $speed;
    }

    /**
     * Calculate mined blocks over a period of time
     */
    public function getMinedBlocks($mine_id)
    {
        if($this->mine_start_time == null) return 0;

        $mine = Mine::find($mine_id);

        $diff = Carbon::now()->getTimestamp() - Carbon::createFromFormat('Y-m-d H:i:s', $this->mine_start_time)->getTimestamp();
        //$ram_capacity = $this->ram_capacity();
        $mined_blocks = $this->getBaseMiningSpeed() * $diff / (135000 * $mine->difficulty_level);

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
            if ($item->type == ItemType::GRAPHICS_CARD) {
                $item_data = json_decode($item->data, true);
                if (!isset($item_data['attributes']['hash_rate'])) continue;
                $hash_rate += $item_data['attributes']['hash_rate'];
                $num_of_gpu++;
            }
        }

        return ($hash_rate * 60) / (135000 * $mine->difficulty_level);



        return ((($mine->block_reward * 60) / $mine->difficulty_level) / 6480000) * $hash_rate / 60;
    }

    public function ram_capacity()
    {
        $totalSize = 0;
        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true)->get();
        foreach($items as $item) {
            if ($item->type == ItemType::MEMORY) {
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

        $mined_blocks = $this->getMinedBlocks($mine_id);
        $current_mined_bytes = $mined_blocks * $mine->memory_conversion * 20;
        $percentage = $ram_size === 0 ? 0 : round($current_mined_bytes * 100 / $ram_size, 2);

        return Util::formatSizeUnits($current_mined_bytes) . ' / ' . Util::formatSizeUnits($ram_size) . ' (' . $percentage . '%)';
    }

    public function getBaseMiningSpeed()
    {
        $gpu_capacity = $this->getGraphicsCardCapacity();
        $memory_capacity = $this->getMemoryCapacity();
        $storage_capacity = $this->getStorageCapacity();

        $base_speed = min($gpu_capacity, $memory_capacity, $storage_capacity);

        return $base_speed;
    }

    public function getMiningSpeed($mine_id) {
        $mine = Mine::find($mine_id);

        $base_speed = $this->getBaseMiningSpeed();

        return ($base_speed * 60) / (135000 * $mine->difficulty_level);
    }

    public function isComplete()
    {
        $items = Item::where('computer_id', $this->id)->where('in_computer', true)->get();
        $array = [];

        foreach ($items as $item) {
            $array[] = $item->type;
        }

        if((in_array(ItemType::MOTHERBOARD, $array) && in_array(ItemType::PROCESSOR, $array)) && in_array(ItemType::GRAPHICS_CARD, $array) && in_array(ItemType::HARD_DRIVE, $array) && in_array(ItemType::MEMORY, $array) && in_array(ItemType::POWER_SUPPLY, $array)) return true;
        return false;
    }

    public function updateDurability() {
        $items = Item::where('computer_id', Session::get('computer_id'))->where('in_computer', true);
    }
}
