<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'usuario1',
            'email'    => 'usuario1@test.com',
            'password' => 'password123',
        ]);

        User::create([
            'username' => 'usuario2',
            'email'    => 'usuario2@test.com',
            'password' => 'password123',
        ]);
    }
}