<?php

namespace Database\Seeders;

use App\Shop;
use App\ShopItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = Shop::updateOrCreate(['type' => 1], [
            'name' => "Daily Shop",
            'currency_id' => 1,
            'enabled' => true,
            'reset_date' => Carbon::now()->endOfDay()
        ]);

        for ($i = 0; $i < 8; $i++) {
            ShopItem::updateOrCreate(['id' => $i + 1], [
                'shop_id' => $shop->id,
                'data' => json_encode([]),
                'price' => rand(30, 400),
                'discount' => rand(0, 100) < 5 ? rand(5, 30) : 0,
                'type' => rand(1, 6),
                'tier' => rand(1, 4),
                'rarity' => rand(1, 5)
            ]);
        }

        $shop = Shop::updateOrCreate(['type' => 2], [
            'name' => "Weekly Shop",
            'currency_id' => 1,
            'enabled' => true,
            'reset_date' => Carbon::now()->endOfWeek()
        ]);

        for ($i = 8; $i < 16; $i++) {
            ShopItem::updateOrCreate(['id' => $i + 1], [
                'shop_id' => $shop->id,
                'data' => json_encode([]),
                'price' => rand(30, 400),
                'discount' => rand(0, 100) < 5 ? rand(15, 50) : 0,
                'type' => rand(1, 6),
                'tier' => rand(1, 4),
                'rarity' => rand(1, 5)
            ]);
        }
    }
}
