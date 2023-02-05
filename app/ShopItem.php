<?php

namespace App;

use App\Enums\ItemRarity;
use App\Enums\ItemTier;
use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    use HasFactory;

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function getPrice() {
        if($this->discount > 0) {
            return number_format($this->price * ((100 - $this->discount) / 100), 2);
        }

        return $this->price;
    }

    public function getName()
    {
        return ItemTier::getDescription($this->tier) . " " . ItemRarity::getDescription($this->rarity) . ($this->rarity == 1 ? "" : " ") . ItemType::getDescription($this->type);
    }

    public function getRarity($display = false)
    {
        return $display ? ItemRarity::getDescription($this->rarity) : strtolower(ItemRarity::getKey($this->rarity));
    }

    public function getImage()
    {
        switch ($this->type) {
            case ItemType::MOTHERBOARD:
                $image = 'motherboard.png';
                break;
            case ItemType::PROCESSOR:
                $image = 'processor.png';
                break;
            case ItemType::GRAPHICS_CARD:
                $image = 'graphics_card.png';
                break;
            case ItemType::HARD_DRIVE:
                $image = 'hard_drive.png';
                break;
            case ItemType::MEMORY:
                $image = 'memory.png';
                break;
            case ItemType::POWER_SUPPLY:
                $image = 'power_supply.png';
                break;
            default:
                $image = '';
                break;
        }
        return asset('storage/images/items/' . $image);
    }
}
