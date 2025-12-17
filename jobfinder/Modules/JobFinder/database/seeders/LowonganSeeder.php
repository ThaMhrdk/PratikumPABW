<?php

namespace Modules\JobFinder\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\JobFinder\App\Models\Lowongan;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lowongan = [
            [
                'posisi' => 'Web Developer',
                'perusahaan' => 'PT Teknologi Bandung',
                'lokasi_kerja' => 'Bandung',
                'deskripsi' => 'Dibutuhkan Web Developer berpengalaman minimal 2 tahun. Menguasai PHP, Laravel, dan MySQL.',
                'gaji' => 8000000,
            ],
            [
                'posisi' => 'Staff Administrasi',
                'perusahaan' => 'CV Maju Bersama',
                'lokasi_kerja' => 'Cimahi',
                'deskripsi' => 'Dibutuhkan Staff Administrasi yang teliti dan bisa mengoperasikan Ms. Office.',
                'gaji' => 4500000,
            ],
            [
                'posisi' => 'Marketing Executive',
                'perusahaan' => 'PT Sukses Selalu',
                'lokasi_kerja' => 'Bandung',
                'deskripsi' => 'Mencari Marketing Executive yang komunikatif dan memiliki kemampuan negosiasi yang baik.',
                'gaji' => 5000000,
            ],
            [
                'posisi' => 'Graphic Designer',
                'perusahaan' => 'Creative Studio',
                'lokasi_kerja' => 'Bandung',
                'deskripsi' => 'Dibutuhkan Graphic Designer yang kreatif. Menguasai Adobe Photoshop, Illustrator.',
                'gaji' => 6000000,
            ],
            [
                'posisi' => 'Customer Service',
                'perusahaan' => 'PT Pelayanan Prima',
                'lokasi_kerja' => 'Soreang',
                'deskripsi' => 'Mencari Customer Service yang ramah dan sabar dalam melayani pelanggan.',
                'gaji' => 4000000,
            ],
        ];

        foreach ($lowongan as $data) {
            Lowongan::create($data);
        }
    }
}
