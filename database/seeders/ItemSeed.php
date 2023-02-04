<?php

namespace Database\Seeders;

use App\ItemGenerator;
use Illuminate\Database\Seeder;

class ItemSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ItemGenerator = new ItemGenerator();

        $ItemGenerator->createItem(1, 1, 1, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 2, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 3, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 4, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 5, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 6, ['quality' => 100]);

        $ItemGenerator->createItem(2, 1, 1, ['quality' => 100]);
        $ItemGenerator->createItem(2, 1, 2, ['quality' => 100]);
        $ItemGenerator->createItem(2, 1, 3, ['quality' => 100]);
        $ItemGenerator->createItem(2, 1, 4, ['quality' => 100]);
        $ItemGenerator->createItem(2, 1, 5, ['quality' => 100]);
        $ItemGenerator->createItem(2, 1, 6, ['quality' => 100]);
    }
}
