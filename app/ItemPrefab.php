<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPrefab extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getRarity($display = true)
    {
        switch ($this->rarity) {
            default:
            case 1:
                $rarity = 'Common';
                break;
            case 2:
                $rarity = 'Exceptional';
                break;
            case 3:
                $rarity = 'Modern';
                break;
            case 4:
                $rarity = 'Advanced';
                break;
            case 5:
                $rarity = 'Unique';
                break;
        }

        return $display ? $rarity : strtolower($rarity);
    }

    public function getImage()
    {
        return asset('storage/images/items/' . $this->image);
    }
}
