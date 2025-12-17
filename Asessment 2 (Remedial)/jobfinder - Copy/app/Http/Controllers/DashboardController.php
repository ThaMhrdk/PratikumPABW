<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->pelamarDashboard();
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        $totalLowongan = Lowongan::count();
        $totalLamaran = Lamaran::count();
        $totalPelamar = User::where('role', 'pelamar')->count();
        
        $recentLowongan = Lowongan::latest()->take(5)->get();
        $recentLamaran = Lamaran::with(['user', 'lowongan'])->latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalLowongan',
            'totalLamaran', 
            'totalPelamar',
            'recentLowongan',
            'recentLamaran'
        ));
    }

    /**
     * Pelamar Dashboard
     */
    private function pelamarDashboard()
    {
        $user = Auth::user();
        $totalLowongan = Lowongan::count();
        $myLamaran = Lamaran::where('user_id', $user->id)->count();
        
        $recentLowongan = Lowongan::latest()->take(5)->get();
        $myRecentLamaran = Lamaran::with('lowongan')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.pelamar', compact(
            'totalLowongan',
            'myLamaran',
            'recentLowongan',
            'myRecentLamaran'
        ));
    }
}
