<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'SuperAdmin@gmail.com',
            'role' => 1,
            'phone' => '60123456789',
            'password' => Hash::make('super1234'),
        ]);

        User::create([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'role' => 0,
            'phone' => '60123456789',
            'password' => Hash::make('user1234'),
        ]);
    }
}
