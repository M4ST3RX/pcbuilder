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
        $itemPrefab = ItemPrefab::where('tier', $tier)->where('rarity', $rarity)->where('type', $type)->first();
        if(!$itemPrefab) return false;
        $attributes = $this->randomAttributes($itemPrefab->type);

        $data = [
            'attributes' => []
        ];

        $this->item = new Item();
        $this->item->computer_id = Session::get('computer_id', 1);
        $this->item->item_prefab_id = $itemPrefab->id;
        $this->item->in_computer = false;
        $this->item->slot = $this->inventoryManager->getNextAvailableSlot();
        $this->item->quality = isset($override_data['quality']) ? $override_data['quality'] : $this->randomQuality($itemPrefab->tier, $itemPrefab->rarity);
        $this->item->level = 1;

        foreach($attributes as $attribute) {
            switch($attribute) {
                case 'size':
                    $range = Util::getStorageQualityRange($itemPrefab->tier, $itemPrefab->rarity);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'power':
                    $range = Util::getPowerQualityRange($itemPrefab->tier, $itemPrefab->rarity);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'power_usage':
                    $range = Util::getPowerUsageQualityRange($itemPrefab->tier, $itemPrefab->rarity, $itemPrefab->type);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'hash_rate':
                    $range = Util::getHashRateQualityRange($itemPrefab->tier, $itemPrefab->rarity, $itemPrefab->type);
                    $data['attributes'][$attribute] = round(($this->item->quality / 100) * ($range['max'] - $range['min']) + $range['min'], 2);
                    break;
                case 'cores':
                    $range = Util::getCoresQualityRange($itemPrefab->tier, $itemPrefab->rarity);
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
