<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\JobFinder\Models\Lowongan;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lowongans = [
            [
                'posisi' => 'Web Developer',
                'perusahaan' => 'PT Teknologi Bandung',
                'lokasi_kerja' => 'Soreang, Kab. Bandung',
                'deskripsi' => 'Mencari web developer berpengalaman dengan skill Laravel, Vue.js, dan MySQL. Bertanggung jawab untuk mengembangkan dan memelihara aplikasi web perusahaan.',
                'gaji' => 8000000,
            ],
            [
                'posisi' => 'Staff Administrasi',
                'perusahaan' => 'CV Maju Bersama',
                'lokasi_kerja' => 'Banjaran, Kab. Bandung',
                'deskripsi' => 'Dibutuhkan staff administrasi untuk mengelola dokumen dan surat menyurat perusahaan. Kandidat harus teliti dan menguasai Microsoft Office.',
                'gaji' => 4500000,
            ],
            [
                'posisi' => 'Marketing Executive',
                'perusahaan' => 'PT Sukses Makmur',
                'lokasi_kerja' => 'Cileunyi, Kab. Bandung',
                'deskripsi' => 'Bertanggung jawab untuk memasarkan produk perusahaan dan mencari klien baru. Pengalaman di bidang sales minimal 2 tahun.',
                'gaji' => 6000000,
            ],
            [
                'posisi' => 'Operator Produksi',
                'perusahaan' => 'PT Pabrik Tekstil Bandung',
                'lokasi_kerja' => 'Majalaya, Kab. Bandung',
                'deskripsi' => 'Mengoperasikan mesin produksi dan memastikan kualitas produk. Bersedia bekerja shift.',
                'gaji' => 4000000,
            ],
            [
                'posisi' => 'Akuntan',
                'perusahaan' => 'PT Finansial Sejahtera',
                'lokasi_kerja' => 'Ciwidey, Kab. Bandung',
                'deskripsi' => 'Mengelola laporan keuangan perusahaan, pajak, dan audit. Minimal D3 Akuntansi dengan pengalaman 1 tahun.',
                'gaji' => 7000000,
            ],
        ];

        foreach ($lowongans as $data) {
            // Gunakan updateOrCreate untuk menghindari duplikasi
            Lowongan::updateOrCreate(
                ['posisi' => $data['posisi'], 'perusahaan' => $data['perusahaan']],
                $data
            );
        }
    }
}
