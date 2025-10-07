<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    private $psikologs = [
        'Dr. Muhammad Anantha Mahardika Ridwan - Spesialis Rasa Kesepian',
        'Dr. Mumpuni Nur Idzati - Spesialis Rasa Kebaperan ',
        'Dr. Hani Nadia Hendra - Psikoterapi Banyak Pikiran'
    ];

    public function index()
    {
        // tampilkan form input
        return view('create', ['psikologs' => $this->psikologs]);
    }

    public function store(Request $request)
    {
        // ambil data dari form
        $data = [
            'nama' => $request->nama,
            'usia' => $request->usia,
            'jurusan' => $request->jurusan,
            'psikolog' => $request->psikolog
        ];

        // ambil data lama dari session, tambahkan yang baru
        $bookings = session('bookings', []);
        $bookings[] = $data;
        session(['bookings' => $bookings]);

        // tampilkan ke halaman hasil
        return view('result', ['bookings' => $bookings]);
    }

    public function reset()
    {
        // hapus semua data
        session()->forget('bookings');
        return redirect('/booking');
    }
}