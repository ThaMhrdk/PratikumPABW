<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        Fakultas::create(['Idfakultas' => 'FEB', 'nmfakultas' => 'Fakultas Ekonomi dan Bisnis', 'kdfakultas' => 'FEB']);
        Fakultas::create(['Idfakultas' => 'FIF', 'nmfakultas' => 'Fakultas Informatika', 'kdfakultas' => 'FIF']);
        Fakultas::create(['Idfakultas' => 'FIK', 'nmfakultas' => 'Fakultas Industri Kreatif', 'kdfakultas' => 'FIK']);
        Fakultas::create(['Idfakultas' => 'FIT', 'nmfakultas' => 'Fakultas Ilmu Terapan', 'kdfakultas' => 'FIT']);
        Fakultas::create(['Idfakultas' => 'FKB', 'nmfakultas' => 'Fakultas Komunikasi dan Bisnis', 'kdfakultas' => 'FKB']);
        Fakultas::create(['Idfakultas' => 'FKS', 'nmfakultas' => 'Fakultas Komunikasi & Ilmu Sosial', 'kdfakultas' => 'FKS']);
        Fakultas::create(['Idfakultas' => 'FRI', 'nmfakultas' => 'Fakultas Rekayasa Industri', 'kdfakultas' => 'FRI']);
        Fakultas::create(['Idfakultas' => 'FTE', 'nmfakultas' => 'Fakultas Teknik Elektro', 'kdfakultas' => 'FTE']);
    }
}