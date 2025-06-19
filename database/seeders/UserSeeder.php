<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'rifmulyawan@gmail.com'],
            [
                'name' => 'Arief',
                'password' => Hash::make('Arief0812'),
                'role' => 'admin',
            ]
        );
    }
}

