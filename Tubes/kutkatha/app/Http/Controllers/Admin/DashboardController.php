<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Psikolog;
use App\Models\Booking;
use App\Models\Consultation;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalPsikologs = Psikolog::count();
        $verifiedPsikologs = Psikolog::where('verification_status', 'verified')->count();
        $pendingVerifications = Psikolog::where('verification_status', 'pending')->count();
        $totalConsultations = Consultation::where('status', 'completed')->count();
        $totalBookings = Booking::count();

        $recentBookings = Booking::with(['user', 'schedule.psikolog.user'])
            ->latest()
            ->take(10)
            ->get();

        $pendingPsikologs = Psikolog::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $monthlyConsultations = Consultation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPsikologs',
            'verifiedPsikologs',
            'pendingVerifications',
            'totalConsultations',
            'totalBookings',
            'recentBookings',
            'pendingPsikologs',
            'monthlyConsultations'
        ));
    }
}
