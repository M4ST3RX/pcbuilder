<?php

use Illuminate\Database\Seeder;

class ComputerBrandSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'name' => 'HP',
                'slug' => 'hp'
            ],
            [
                'name' => 'ASUS',
                'slug' => 'asus'
            ],
            [
                'name' => 'Lenovo',
                'slug' => 'lenovo'
            ]
        ];

        foreach ($brands as $brand) {
            \App\ComputerBrand::firstOrCreate([
                'name' => $brand['name']
            ],[
                'slug' => $brand['slug']
            ]);
        }
    }
}
