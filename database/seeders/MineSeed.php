<?php

namespace Database\Seeders;

use App\Mine;
use Illuminate\Database\Seeder;

class MineSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mine = new Mine();
        $mine->name = "Silver";
        $mine->currency_id = 2;
        $mine->block_reward = 2;
        $mine->difficulty_level = 1;
        $mine->memory_conversion = 1;
        $mine->exchange_rate = 0.5;
        $mine->save();

        $mine = new Mine();
        $mine->name = "Gold";
        $mine->currency_id = 3;
        $mine->block_reward = 5;
        $mine->difficulty_level = 3;
        $mine->memory_conversion = 1;
        $mine->exchange_rate = 0.5;
        $mine->save();

        $mine = new Mine();
        $mine->name = "Platinum";
        $mine->currency_id = 4;
        $mine->block_reward = 10;
        $mine->difficulty_level = 5;
        $mine->memory_conversion = 1;
        $mine->exchange_rate = 0.5;
        $mine->save();
    }
}
