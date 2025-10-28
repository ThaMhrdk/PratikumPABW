<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prodi::create(['Idprodi' => 'P0005', 'nmprodi' => 'Informatika', 'jenjang' => 'S1', 'kdprodi' => 'IF', 'Idfakultas' => 'FIF']);
        Prodi::create(['Idprodi' => 'P0008', 'nmprodi' => 'Teknik Industri', 'jenjang' => 'D3', 'kdprodi' => 'TI-D3', 'Idfakultas' => 'FRI']);
        Prodi::create(['Idprodi' => 'P0012', 'nmprodi' => 'Akuntansi', 'jenjang' => 'S1', 'kdprodi' => 'AKT', 'Idfakultas' => 'FEB']);
        Prodi::create(['Idprodi' => 'P0015', 'nmprodi' => 'Ilmu Komunikasi', 'jenjang' => 'S1', 'kdprodi' => 'ILKOM', 'Idfakultas' => 'FKS']);
        Prodi::create(['Idprodi' => 'P0020', 'nmprodi' => 'Desain Komunikasi Visual', 'jenjang' => 'S1', 'kdprodi' => 'DKV', 'Idfakultas' => 'FIK']);
        Prodi::create(['Idprodi' => 'P0030', 'nmprodi' => 'Sistem Informasi Kota Cerdas', 'jenjang' => 'S1 Terapan', 'kdprodi' => 'SIKC', 'Idfakultas' => 'FIT']);
        Prodi::create(['Idprodi' => 'P0031', 'nmprodi' => 'Teknik Telekomunikasi', 'jenjang' => 'S1', 'kdprodi' => 'TT', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0032', 'nmprodi' => 'Teknik Telekomunikasi (International Class)', 'jenjang' => 'S1', 'kdprodi' => 'TT-IC', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0033', 'nmprodi' => 'Teknik Elektro', 'jenjang' => 'S1', 'kdprodi' => 'TE', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0034', 'nmprodi' => 'Teknik Komputer', 'jenjang' => 'S1', 'kdprodi' => 'TK', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0035', 'nmprodi' => 'Teknik Biomedis', 'jenjang' => 'S1', 'kdprodi' => 'TB', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0036', 'nmprodi' => 'Teknik Fisika', 'jenjang' => 'S1', 'kdprodi' => 'TF', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0037', 'nmprodi' => 'Teknik Sistem Energi', 'jenjang' => 'S1', 'kdprodi' => 'TSE', 'Idfakultas' => 'FTE']);
        Prodi::create(['Idprodi' => 'P0038', 'nmprodi' => 'Teknik Logistik', 'jenjang' => 'S1', 'kdprodi' => 'TL', 'Idfakultas' => 'FRI']);
        Prodi::create(['Idprodi' => 'P0039', 'nmprodi' => 'Sistem Informasi', 'jenjang' => 'D3', 'kdprodi' => 'SI-D3', 'Idfakultas' => 'FRI']);
        Prodi::create(['Idprodi' => 'P0041', 'nmprodi' => 'Teknologi Informasi', 'jenjang' => 'S1', 'kdprodi' => 'TI', 'Idfakultas' => 'FIF']);
        Prodi::create(['Idprodi' => 'P0042', 'nmprodi' => 'Rekayasa Perangkat Lunak', 'jenjang' => 'S1', 'kdprodi' => 'RPL', 'Idfakultas' => 'FIF']);
        Prodi::create(['Idprodi' => 'P0043', 'nmprodi' => 'Data Science', 'jenjang' => 'S1', 'kdprodi' => 'DS', 'Idfakultas' => 'FIF']);
        Prodi::create(['Idprodi' => 'P0044', 'nmprodi' => 'PJJ Informatika', 'jenjang' => 'S1', 'kdprodi' => 'PJJ-IF', 'Idfakultas' => 'FIF']);
        Prodi::create(['Idprodi' => 'P0045', 'nmprodi' => 'Teknologi Informasi (Cyber Security)', 'jenjang' => 'S1', 'kdprodi' => 'TI-CS', 'Idfakultas' => 'FIF']);
        Prodi::create(['Idprodi' => 'P0046', 'nmprodi' => 'Manajemen Bisnis Telekomunikasi & Informatika', 'jenjang' => 'S1', 'kdprodi' => 'MBTI', 'Idfakultas' => 'FEB']);
        Prodi::create(['Idprodi' => 'P0047', 'nmprodi' => 'Administrasi Bisnis', 'jenjang' => 'S1', 'kdprodi' => 'AB', 'Idfakultas' => 'FEB']);
        Prodi::create(['Idprodi' => 'P0048', 'nmprodi' => 'Digital Business', 'jenjang' => 'S1', 'kdprodi' => 'DB', 'Idfakultas' => 'FEB']);
        Prodi::create(['Idprodi' => 'P0049', 'nmprodi' => 'Hubungan Masyarakat Digital', 'jenjang' => 'S1', 'kdprodi' => 'HUMAS', 'Idfakultas' => 'FEB']);
        Prodi::create(['Idprodi' => 'P0050', 'nmprodi' => 'Penyiaran Digital', 'jenjang' => 'S1', 'kdprodi' => 'PD', 'Idfakultas' => 'FEB']);
        Prodi::create(['Idprodi' => 'P0051', 'nmprodi' => 'Digital Public Relations', 'jenjang' => 'S1', 'kdprodi' => 'DPR', 'Idfakultas' => 'FKS']);
        Prodi::create(['Idprodi' => 'P0052', 'nmprodi' => 'Digital Content Broadcasting', 'jenjang' => 'S1', 'kdprodi' => 'DCB', 'Idfakultas' => 'FKS']);
        Prodi::create(['Idprodi' => 'P0053', 'nmprodi' => 'Psikologi (Digital Psychology)', 'jenjang' => 'S1', 'kdprodi' => 'PSI', 'Idfakultas' => 'FKS']);
        Prodi::create(['Idprodi' => 'P0054', 'nmprodi' => 'Industrial Design', 'jenjang' => 'S1', 'kdprodi' => 'ID', 'Idfakultas' => 'FIK']);
        Prodi::create(['Idprodi' => 'P0055', 'nmprodi' => 'Desain Interior', 'jenjang' => 'S1', 'kdprodi' => 'DI', 'Idfakultas' => 'FIK']);
        Prodi::create(['Idprodi' => 'P0056', 'nmprodi' => 'Kriya (Fashion & Textile Design)', 'jenjang' => 'S1', 'kdprodi' => 'KRIYA', 'Idfakultas' => 'FIK']);
        Prodi::create(['Idprodi' => 'P0057', 'nmprodi' => 'Seni Rupa', 'jenjang' => 'S1', 'kdprodi' => 'SR', 'Idfakultas' => 'FIK']);
        Prodi::create(['Idprodi' => 'P0058', 'nmprodi' => 'Film dan Animasi', 'jenjang' => 'S1', 'kdprodi' => 'FA', 'Idfakultas' => 'FIK']);
        Prodi::create(['Idprodi' => 'P0059', 'nmprodi' => 'Teknologi Rekayasa Multimedia', 'jenjang' => 'D4', 'kdprodi' => 'TRM', 'Idfakultas' => 'FIT']);
        Prodi::create(['Idprodi' => 'P0060', 'nmprodi' => 'Teknologi Rekayasa Perangkat Lunak', 'jenjang' => 'D4', 'kdprodi' => 'TRPL', 'Idfakultas' => 'FIT']);
        Prodi::create(['Idprodi' => 'P0061', 'nmprodi' => 'Rekayasa Keamanan Siber', 'jenjang' => 'D4', 'kdprodi' => 'RKS', 'Idfakultas' => 'FIT']);
        Prodi::create(['Idprodi' => 'P0062', 'nmprodi' => 'Sistem Informasi Akuntansi', 'jenjang' => 'D4', 'kdprodi' => 'SIA', 'Idfakultas' => 'FIT']);
        Prodi::create(['Idprodi' => 'P0063', 'nmprodi' => 'Teknologi Komputer', 'jenjang' => 'D4', 'kdprodi' => 'TK-D4', 'Idfakultas' => 'FIT']);
    }
}