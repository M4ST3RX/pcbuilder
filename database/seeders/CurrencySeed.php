<?php

namespace Database\Seeders;

use App\Currency;
use Illuminate\Database\Seeder;

class CurrencySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::updateOrCreate(['name' => '$', 'is_front' => true, 'image' => null, 'is_crypto' => false]);
        Currency::updateOrCreate(['name' => 'SilverCoin']);
        Currency::updateOrCreate(['name' => 'GoldCoin']);
        Currency::updateOrCreate(['name' => 'PlatinumCoin']);
    }
}
