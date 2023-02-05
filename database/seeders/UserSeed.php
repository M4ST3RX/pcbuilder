<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->password = Hash::make('asd');
        $user->email = 'asd@example.com';
        $user->username = 'asd';
        $user->save();
    }
}
