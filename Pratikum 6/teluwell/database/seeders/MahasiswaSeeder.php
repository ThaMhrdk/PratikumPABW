<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker; 

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); 

        $prodiIds = Prodi::pluck('Idprodi');

        for ($i = 0; $i < 10; $i++) {
            Mahasiswa::create([
                'nim' => $faker->unique()->numerify('7070124####'),
                'email' => $faker->unique()->safeEmail(),
                'nmdepan' => $faker->firstName(), 
                'nmbelakang' => $faker->lastName(), 
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'Idprodi' => $prodiIds->random(), 
                'password' => Hash::make('123456')
            ]);
        }
    }
}