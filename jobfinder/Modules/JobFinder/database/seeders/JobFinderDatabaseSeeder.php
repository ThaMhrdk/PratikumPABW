<?php

namespace Modules\JobFinder\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JobFinderDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun Admin
        User::updateOrCreate(
            ['email' => 'admin@jobfinder.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@jobfinder.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Buat akun Pelamar
        User::updateOrCreate(
            ['email' => 'pelamar@jobfinder.com'],
            [
                'name' => 'Pelamar Demo',
                'email' => 'pelamar@jobfinder.com',
                'password' => Hash::make('password123'),
                'role' => 'pelamar',
            ]
        );

        // Seed lowongan sample
        $this->call(LowonganSeeder::class);
    }
}
