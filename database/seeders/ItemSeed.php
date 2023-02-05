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

        $ItemGenerator->createItem(3, 3, 1, ['quality' => 100]);
        $ItemGenerator->createItem(3, 3, 2, ['quality' => 100]);
        $ItemGenerator->createItem(3, 3, 3, ['quality' => 100]);
        $ItemGenerator->createItem(3, 3, 4, ['quality' => 100]);
        $ItemGenerator->createItem(3, 3, 5, ['quality' => 100]);
        $ItemGenerator->createItem(3, 3, 6, ['quality' => 100]);

        $ItemGenerator->createItem(1, 1, 1, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 2, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 3, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 4, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 5, ['quality' => 100]);
        $ItemGenerator->createItem(1, 1, 6, ['quality' => 100]);
    }
}
