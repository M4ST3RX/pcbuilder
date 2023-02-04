<?php

namespace Database\Seeders;

use App\ItemPrefab;
use Illuminate\Database\Seeder;

class ItemPrefabSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rarity_names = [
            1 => 'Common',
            2 => 'Exceptional',
            3 => 'Modern',
            4 => 'Advanced',
            5 => 'Unique'
        ];

        $items = [
            [
                'name' => 'Motherboard',
                'image' => 'motherboard.png',
                'type' => 1
            ],
            [
                'name' => 'Processor',
                'image' => 'cpu.png',
                'type' => 2
            ],
            [
                'name' => 'Graphics Card',
                'image' => 'graphics_card.png',
                'type' => 3
            ],
            [
                'name' => 'Hard Drive',
                'image' => 'hard_drive.png',
                'type' => 4
            ],
            [
                'name' => 'Memory',
                'image' => 'memory.png',
                'type' => 5
            ],
            [
                'name' => 'Power Supply',
                'image' => 'power_supply.png',
                'type' => 6
            ],
        ];

        for ($tier = 1; $tier <= 4; $tier++) {
            for ($rarity = 1; $rarity <= 5; $rarity++) {
                foreach ($items as $item) {
                    ItemPrefab::updateOrCreate([
                        'name' => $rarity_names[$rarity] . ' ' . $item['name'],
                        'tier' => $tier,
                        'rarity' => $rarity,
                        'type' => $item['type']
                    ], [
                        'image' => $item['image']
                    ]);
                }
            }
        }
    }
}
