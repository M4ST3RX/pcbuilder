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
                'name' => 'MemoryGrid', //ram
                'slug' => 'memory-grid'
            ],
            [
                'name' => 'OpticDrive', //hdd
                'slug' => 'optic-drive'
            ],
            [
                'name' => 'drivebyte', //ssd
                'slug' => 'drivebyte'
            ],
            [
                'name' => 'CHIPLUMO', //cpu
                'slug' => 'chiplumo'
            ],
            [
                'name' => 'Chipnetic', //cpu
                'slug' => 'chipnetic'
            ],
            [
                'name' => 'memorybay', //ram
                'slug' => 'memorybay'
            ],
            [
                'name' => 'TECHYX', //case
                'slug' => 'techyx'
            ],
            [
                'name' => 'MCOMPUTER', //case
                'slug' => 'm-computer'
            ],
            [
                'name' => 'gamegenix', //video card
                'slug' => 'gamegenix'
            ],
            [
                'name' => 'NETVISION', //video card
                'slug' => 'netvision'
            ],
            [
                'name' => 'POWERNOMIC', //power supply
                'slug' => 'powernomic'
            ],
            [
                'name' => 'computio', //motherboard
                'slug' => 'computio'
            ]
        ];

        foreach ($brands as $brand) {
            \App\ComputerBrand::updateOrCreate([
                'name' => $brand['name']
            ],[
                'slug' => $brand['slug']
            ]);
        }
    }
}
