<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswas = [
            [
                'nama' => 'Michael El Vandal',
                'jurusan' => 'Sistem Informasi Valorant',
                'umur' => 21,
                'kode_booking' => 'BK2025-001',
                'jam_booking' => '14:30 WIB',
                'status' => 'Mahasiswa',
                'konselor' => 'Anantha',
            ],
            [
                'nama' => 'Mahardika Dermawan',
                'sekolah' => 'SMK Telkom Bandung',
                'umur' => 14,
                'kode_booking' => 'BK2025-002',
                'jam_booking' => '16:30 WIB',
                'status' => 'Pelajar',
                'konselor' => 'Dika',
            ],
            [
                'nama' => 'Azhar El Gimang',
                'kantor' => 'PT Hayo Tebak',
                'umur' => 23,
                'kode_booking' => 'BK2025-003',
                'jam_booking' => '12:00 WIB',
                'status' => 'Pekerja',
                'konselor' => 'Hani',
            ],
            [
                'nama' => 'Ebentukam Al Garam',
                'umur' => 65,
                'kode_booking' => 'BK2025-004',
                'jam_booking' => '08:30 WIB',
                'status' => 'Pensiun',
                'konselor' => 'Tyas',
            ],
        ];

        return view('dashboard', compact('mahasiswas'));
    }
}
