<?php

use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Hardware',
            'Software',
            'Hosting'
        ];

        foreach ($types as $type) {
            \App\CompanyType::firstOrCreate([
                'type' => $type
            ]);
        }
    }
}
