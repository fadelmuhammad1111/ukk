<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 👑 ADMIN
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 👷 STAFF 1
        User::create([
            'name' => 'Staff 1',
            'email' => 'staff1@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
        ]);

        // 👷 STAFF 2
        User::create([
            'name' => 'Staff 2',
            'email' => 'staff2@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
        ]);
    }
}
