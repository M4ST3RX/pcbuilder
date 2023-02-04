<?php

use Database\Seeders\CurrencySeed;
use Database\Seeders\ItemPrefabSeed;
use Database\Seeders\ItemSeed;
use Database\Seeders\MineSeed;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ItemSeed::class);
        $this->call(CurrencySeed::class);
        $this->call(MineSeed::class);
        $this->call(ShopSeed::class);
    }
}
