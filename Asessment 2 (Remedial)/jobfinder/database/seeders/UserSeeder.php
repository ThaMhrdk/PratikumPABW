<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan updateOrCreate agar tidak error jika data sudah ada
        User::updateOrCreate(
            ['email' => 'admin@jobfinder.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelamar@jobfinder.com'],
            [
                'name' => 'Pelamar Demo',
                'password' => Hash::make('password'),
                'role' => 'pelamar',
            ]
        );
    }
}
