<?php

namespace Modules\JobFinder\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\JobFinder\Models\Lamaran;
use Modules\JobFinder\Models\Lowongan;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard berdasarkan role user
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->tampilkanDashboardAdmin();
        }

        return $this->tampilkanDashboardPelamar();
    }

    /**
     * Dashboard untuk Admin
     */
    private function tampilkanDashboardAdmin()
    {
        $statistik = [
            'total_lowongan' => Lowongan::count(),
            'total_lamaran' => Lamaran::count(),
            'total_pelamar' => User::where('role', 'pelamar')->count(),
        ];
        
        $lowonganTerbaru = Lowongan::latest()->take(5)->get();
        $lamaranTerbaru = Lamaran::with(['user', 'lowongan'])->latest()->take(5)->get();

        return view('jobfinder::dashboard.admin', compact(
            'statistik',
            'lowonganTerbaru',
            'lamaranTerbaru'
        ));
    }

    /**
     * Dashboard untuk Pelamar
     */
    private function tampilkanDashboardPelamar()
    {
        $user = Auth::user();
        
        $statistik = [
            'total_lowongan' => Lowongan::count(),
            'lamaran_saya' => Lamaran::where('user_id', $user->id)->count(),
        ];
        
        $lowonganTerbaru = Lowongan::latest()->take(5)->get();
        $lamaranSayaTerbaru = Lamaran::with('lowongan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('jobfinder::dashboard.pelamar', compact(
            'statistik',
            'lowonganTerbaru',
            'lamaranSayaTerbaru'
        ));
    }
}
