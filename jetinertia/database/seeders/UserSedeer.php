<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
            User::insert(
                [
                    'name' => Str::random(12),
                    'email' => Str::random(8).'gmail.com',
                    'password' => Hash::make('password'),
                ]
            );   
        }
    }
}
