<?php

use Illuminate\Database\Seeder;

class HardwareTypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Case',
            'CPU',
            'RAM',
            'Hard Disk Drive',
            'Solid State Drive',
            'Motherboard',
            'Video Card',
            'Power Supply'
        ];

        foreach ($types as $type) {
            \App\HardwareType::firstOrCreate([
                'type' => $type
            ]);
        }
    }
}
