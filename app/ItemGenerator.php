<?php

namespace App;

use App\Managers\InventoryManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class ItemGenerator extends Model
{
    use HasFactory;

    private $inventoryManager;

    public function __construct()
    {
        $this->inventoryManager = new InventoryManager();
    }

    public function createItem($tier, $rarity, $type, $override_data = [])
    {

        $attributes = $this->randomAttributes($type);

        $data = [
            'attributes' => []
        ];

        $this->item = new Item();
        $this->item->computer_id = Session::get('computer_id', 1);

        $this->item->in_computer = false;
        $this->item->slot = $this->inventoryManager->getNextAvailableSlot();
        $this->item->quality = isset($override_data['quality']) ? $override_data['quality'] : $this->randomQuality($tier, $rarity);
        $this->item->level = 1;
        $this->item->tier = $tier;
        $this->item->rarity = $rarity;
        $this->item->type = $type;

        foreach($attributes as $attribute) {
            switch($attribute) {
                case 'size':
                    $range = Util::getStorageQualityRange($tier, $rarity);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'power':
                    $range = Util::getPowerQualityRange($tier, $rarity);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'power_usage':
                    $range = Util::getPowerUsageQualityRange($tier, $rarity, $type);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'hash_rate':
                    $range = Util::getHashRateQualityRange($tier, $rarity, $type);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'cores':
                    $range = Util::getCoresQualityRange($tier, $rarity);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 0);
                    break;
                default:
                    $data['attributes'][$attribute] = 0;
                    break;
            }
        }

        if (isset($override_data['data'])) {
            $data = array_merge($data, $override_data['data']);
        }

        $this->item->data = json_encode($data);

        if ($this->item->slot !== null) {
            $this->item->save();
        }
    }

    public function randomQuality($tier, $rarity) {

        $high = 0.5 * $this->getTierAndRarityChance($tier, $rarity);
        $medium = 0.5;
        $randomNumber = mt_rand(0, 10000) / 10000;

        if ($randomNumber < $high) {
            // High
            return round(mt_rand(8000, 10000) / 100);
        } elseif ($randomNumber < $high + $medium) {
            // Medium
            return round(mt_rand(2500, 7900) / 100);
        } else {
            // Low
            return round(mt_rand(0, 2400) / 100);
        }
    }

    public function getTierAndRarityChance($tier, $rarity) {
        $normalizedTierValue = $tier / 4;
        $normalizedRarityValue = $rarity / 5;
        $weight = 0.7;

        return 1 - ($normalizedTierValue * $weight + $normalizedRarityValue * (1 - $weight));
    }

    public function randomAttributes($type) {
        switch($type) {
            case 1:
                return ['power_usage'];
            case 2:
                return ['cores', 'hash_rate', 'power_usage'];
            case 3:
                return ['hash_rate', 'power_usage'];
            case 4:
                return ['size', 'power_usage'];
            case 5:
                return ['size', 'power_usage'];
            case 6:
                return ['power'];
            default:
                return [''];
        }
    }
}
