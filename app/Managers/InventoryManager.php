<?php

namespace App\Managers;

use App\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class InventoryManager extends Model
{
    private $player_items;
    public static $MAX_SLOTS = 12 * 6;

    public function __construct($items = null)
    {
        $this->player_items = collect($items);
    }

    public function getItemAt($index, $pcInventory = false) {
        if($this->player_items->count() == 0) return null;

        $itemAtIndex = null;
        foreach($this->player_items as $item) {
            if($item->slot == $index && $item->in_computer == $pcInventory) {
                $itemAtIndex = $item;
                break;
            }
        }

        return $itemAtIndex;
    }

    public function getItems() {
        return $this->player_items;
    }

    public function getInventoryItems()
    {
        $items = [];
        foreach ($this->player_items as $item) {
            if (!$item->in_computer) {
                $items[] = $item;
            }
        }

        return collect($items);
    }

    public function getComputerItems() {
        $items = [];
        foreach($this->player_items as $item) {
            if($item->in_computer) {
                $items[] = $item;
            }
        }

        return collect($items);
    }

    public function getNextAvailableSlot() {
        //TODO: Remove default
        if($this->player_items->count() != 0) {
            $items = $this->getInventoryItems();
        } else {
            $items = Item::where('computer_id', Session::get('computer_id', 1))->where('in_computer', false)->orderBy('slot', 'ASC')->get();
        }
        if($items->count() >= InventoryManager::$MAX_SLOTS) return null;

        $nextSlotNumber = 0;

        foreach($items as $item) {
            if($item->slot == $nextSlotNumber) {
                $nextSlotNumber++;
            } else {
                break;
            }
        }

        return $nextSlotNumber;
    }

    public function hasSpace() {
        $nextSlot = $this->getNextAvailableSlot();
        if($nextSlot === null) return false;
        return $nextSlot < InventoryManager::$MAX_SLOTS;
    }
}
