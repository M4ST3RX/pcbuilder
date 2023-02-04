<?php

namespace App;

use App\Enums\ItemRarity;
use App\Enums\ItemTier;
use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Model;
use App\Util;

class Item extends Model
{
    public function getItemLevel() {
        $data = json_decode($this->data, true);
        return "Level " . (isset($data['level']) ? $data['level'] : "N/A");
    }

    public function getImage() {
        switch($this->type) {
            case 1:
                $image = 'motherboard.png';
            case 2:
                $image = 'processor.png';
            case 3:
                $image = 'graphics_card.png';
            case 4:
                $image = 'hard_drive.png';
            case 5:
                $image = 'memory.png';
            case 6:
                $image = 'power_supply.png';
            default:
                $image = '';
        }
        return asset('storage/images/items/' . $image);
    }

    public function getItemQualityName() {
        $quality = $this->quality;
        if($quality == null) return "";

        if($quality >= 0 && $quality <= 24) {
            return "low";
        } else if ($quality >= 25 && $quality <= 49) {
            return "medium";
        } else if ($quality >= 50 && $quality <= 79) {
            return "high";
        } else if ($quality >= 80 && $quality <= 100) {
            return "perfect";
        }
    }

    public function getItemAttributes() {
        $data = json_decode($this->data, true);
        $attributes = $data['attributes'];

        $attribute_string = "";

        foreach($attributes as $name => $value) {
            $display_name = ucwords(str_replace('_', ' ', $name));
            switch($name) {
                case "size":
                    $value = Util::formatSizeUnits($value);
                    break;
                case "power":
                case "power_usage":
                    $value = Util::formatPowerUnits($value);
                    break;
                case "hash_rate":
                    $value = Util::formatHashRate($value);
                    break;
                case "cores":
                    $value = $value;
                    break;
                default:
                    break;
            }

            $attribute_string .= "<div>" . $display_name . ": " . $value . "</div>";
        }

        return $attribute_string;
    }

    public function getName()
    {
        ItemTier::getDescription($this->tier) . " " . ItemRarity::getDescription($this->rarity) . " " . ItemType::getDescription($this->type);

    }

    public function getRarity($display = false)
    {
        return $display ? ItemRarity::getDescription($this->rarity) : strtolower(ItemRarity::getKey($this->rarity));
    }
}
