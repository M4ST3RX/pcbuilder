<?php

use Illuminate\Database\Seeder;

class HardwareSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // RAM size in MB
        // HDD, SSD size in GB
        // speed in MB/s
        $hardwares = [
            [
                'hardware_type_id' => 1,
                'name' => 'Case 1',
                'price' => 10,
                'data' => []
            ],
            [
                'hardware_type_id' => 1,
                'name' => 'Case 2',
                'price' => 100,
                'data' => []
            ],
            [
                'hardware_type_id' => 1,
                'name' => 'Case 2',
                'price' => 1000,
                'data' => []
            ],
            [
                'hardware_type_id' => 2,
                'name' => 'CPU 1',
                'price' => 10,
                'data' => [
                    'depends' => [6]
                ]
            ],
            [
                'hardware_type_id' => 2,
                'name' => 'CPU 2',
                'price' => 100,
                'data' => [
                    'depends' => [6]
                ]
            ],
            [
                'hardware_type_id' => 2,
                'name' => 'CPU 3',
                'price' => 1000,
                'data' => [
                    'depends' => [6]
                ]
            ],
            [
                'hardware_type_id' => 3,
                'name' => 'RAM 1',
                'price' => 10,
                'data' => [
                    'depends' => [6],
                    'size' => 64
                ]
            ],
            [
                'hardware_type_id' => 3,
                'name' => 'RAM 2',
                'price' => 100,
                'data' => [
                    'depends' => [6],
                    'size' => 256
                ]
            ],
            [
                'hardware_type_id' => 3,
                'name' => 'RAM 3',
                'price' => 1000,
                'data' => [
                    'depends' => [6],
                    'size' => 1024
                ]
            ],
            [
                'hardware_type_id' => 4,
                'name' => 'HDD 1',
                'price' => 10,
                'data' => [
                    'size' => 512,
                    'speed' => 25
                ]
            ],
            [
                'hardware_type_id' => 4,
                'name' => 'HDD 2',
                'price' => 100,
                'data' => [
                    'size' => 1024,
                    'speed' => 75
                ]
            ],
            [
                'hardware_type_id' => 4,
                'name' => 'HDD 3',
                'price' => 1000,
                'data' => [
                    'size' => 3096,
                    'speed' => 190
                ]
            ],
            [
                'hardware_type_id' => 5,
                'name' => 'SSD 1',
                'price' => 10,
                'data' => [
                    'size' => 64,
                    'speed' => 90
                ]
            ],
            [
                'hardware_type_id' => 5,
                'name' => 'SSD 2',
                'price' => 100,
                'data' => [
                    'size' => 128,
                    'speed' => 180
                ]
            ],
            [
                'hardware_type_id' => 5,
                'name' => 'SSD 3',
                'price' => 1000,
                'data' => [
                    'size' => 256,
                    'speed' => 270
                ]
            ],
            [
                'hardware_type_id' => 6,
                'name' => 'MB 1',
                'price' => 10,
                'data' => []
            ],
            [
                'hardware_type_id' => 6,
                'name' => 'MB 2',
                'price' => 100,
                'data' => []
            ],
            [
                'hardware_type_id' => 6,
                'name' => 'MB 3',
                'price' => 1000,
                'data' => []
            ],
            [
                'hardware_type_id' => 7,
                'name' => 'Video Card 1',
                'price' => 10,
                'data' => [
                    'depends' => [6],
                    'power' => 1
                ]
            ],
            [
                'hardware_type_id' => 7,
                'name' => 'Video Card 2',
                'price' => 100,
                'data' => [
                    'depends' => [6],
                    'power' => 4.6
                ]
            ],
            [
                'hardware_type_id' => 7,
                'name' => 'Video Card 3',
                'price' => 1000,
                'data' => [
                    'depends' => [6],
                    'power' => 17.2
                ]
            ]
        ];

        foreach ($hardwares as $hardware){
            \App\ComputerHardware::updateOrCreate([
                'name' => $hardware['name']
            ],[
                'hardware_type_id' => $hardware['hardware_type_id'],
                'data' => json_encode($hardware['data']),
                'price' => json_encode($hardware['price']),
            ]);
        }
    }
}
