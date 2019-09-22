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
                'name' => 'PC Case',
                'type' => 'case',
                'brand' => 7,
                'price' => 9,
                'data' => []
            ],
            [
                'hardware_type_id' => 1,
                'name' => 'Modern Case',
                'type' => 'case',
                'brand' => 7,
                'price' => 24,
                'data' => []
            ],
            [
                'hardware_type_id' => 1,
                'name' => 'Computer Case',
                'type' => 'case',
                'brand' => 8,
                'price' => 63,
                'data' => []
            ],
            [
                'hardware_type_id' => 2,
                'name' => 'HD 1000',
                'type' => 'cpu',
                'brand' => 4,
                'price' => 52,
                'data' => [
                    'depends' => [6]
                ]
            ],
            [
                'hardware_type_id' => 2,
                'name' => 'Plasma JX-1',
                'type' => 'cpu',
                'brand' => 5,
                'price' => 84,
                'data' => [
                    'depends' => [6]
                ]
            ],
            [
                'hardware_type_id' => 2,
                'name' => 'JTX-860',
                'type' => 'cpu',
                'brand' => 4,
                'price' => 136,
                'data' => [
                    'depends' => [6]
                ]
            ],
            [
                'hardware_type_id' => 3,
                'name' => 'RAM 1',
                'type' => 'ram',
                'brand' => 6,
                'price' => 34,
                'data' => [
                    'depends' => [6],
                    'size' => 16
                ]
            ],
            [
                'hardware_type_id' => 3,
                'name' => 'RAM 2',
                'type' => 'ram',
                'brand' => 6,
                'price' => 71,
                'data' => [
                    'depends' => [6],
                    'size' => 32
                ]
            ],
            [
                'hardware_type_id' => 3,
                'name' => 'NT-20',
                'type' => 'ram',
                'brand' => 6,
                'price' => 93,
                'data' => [
                    'depends' => [6],
                    'size' => 64
                ]
            ],
            [
                'hardware_type_id' => 4,
                'name' => 'Blue',
                'type' => 'hdd',
                'brand' => 2,
                'price' => 24,
                'data' => [
                    'size' => 128,
                    'speed' => 25
                ]
            ],
            [
                'hardware_type_id' => 4,
                'name' => 'Green',
                'type' => 'hdd',
                'brand' => 2,
                'price' => 39,
                'data' => [
                    'size' => 256,
                    'speed' => 75
                ]
            ],
            [
                'hardware_type_id' => 4,
                'name' => 'Red',
                'type' => 'hdd',
                'brand' => 2,
                'price' => 60,
                'data' => [
                    'size' => 512,
                    'speed' => 190
                ]
            ],
            [
                'hardware_type_id' => 5,
                'name' => 'SSD 1',
                'type' => 'ssd',
                'brand' => 3,
                'price' => 67,
                'data' => [
                    'size' => 32,
                    'speed' => 90
                ]
            ],
            [
                'hardware_type_id' => 5,
                'name' => 'SSD 2',
                'type' => 'ssd',
                'brand' => 3,
                'price' => 88,
                'data' => [
                    'size' => 64,
                    'speed' => 180
                ]
            ],
            [
                'hardware_type_id' => 5,
                'name' => 'SSD 3',
                'type' => 'ssd',
                'brand' => 3,
                'price' => 107,
                'data' => [
                    'size' => 128,
                    'speed' => 270
                ]
            ],
            [
                'hardware_type_id' => 6,
                'name' => 'NF-50',
                'type' => 'motherboard',
                'brand' => 12,
                'price' => 40,
                'data' => []
            ],
            [
                'hardware_type_id' => 6,
                'name' => 'NF-60',
                'type' => 'motherboard',
                'brand' => 12,
                'price' => 172,
                'data' => []
            ],
            [
                'hardware_type_id' => 6,
                'name' => 'NF Pro',
                'type' => 'motherboard',
                'brand' => 12,
                'price' => 149,
                'data' => []
            ],
            [
                'hardware_type_id' => 7,
                'name' => 'V1',
                'type' => 'videocard',
                'brand' => 10,
                'price' => 99,
                'data' => [
                    'depends' => [6],
                    'power' => 0.4
                ]
            ],
            [
                'hardware_type_id' => 7,
                'name' => 'V1-G',
                'type' => 'videocard',
                'brand' => 10,
                'price' => 155,
                'data' => [
                    'depends' => [6],
                    'power' => 1.2
                ]
            ],
            [
                'hardware_type_id' => 7,
                'name' => 'GG Gaming',
                'type' => 'videocard',
                'brand' => 9,
                'price' => 259,
                'data' => [
                    'depends' => [6],
                    'power' => 2.8
                ]
            ]
        ];

        foreach ($hardwares as $hardware){
            \App\ComputerHardware::updateOrCreate([
                'name' => $hardware['name']
            ],[
                'hardware_type_id' => $hardware['hardware_type_id'],
                'data' => json_encode($hardware['data']),
                'type' => json_encode($hardware['type']),
                'brand' => json_encode($hardware['brand']),
                'price' => json_encode($hardware['price']),
            ]);
        }
    }
}
