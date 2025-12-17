<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $psikolog = Auth::user()->psikolog;

        if (!$psikolog) {
            return redirect()->route('home')->with('error', 'Profil psikolog tidak ditemukan.');
        }

        $pendingBookings = Booking::with(['user', 'schedule'])
            ->whereHas('schedule', function($q) use ($psikolog) {
                $q->where('psikolog_id', $psikolog->id);
            })
            ->where('status', 'pending')
            ->count();

        $todaySchedules = Schedule::where('psikolog_id', $psikolog->id)
            ->where('date', now()->toDateString())
            ->with(['bookings' => function($q) {
                $q->whereIn('status', ['confirmed', 'pending']);
            }])
            ->orderBy('start_time')
            ->get();

        $totalConsultations = Consultation::whereHas('booking.schedule', function($q) use ($psikolog) {
            $q->where('psikolog_id', $psikolog->id);
        })->where('status', 'completed')->count();

        $upcomingBookings = Booking::with(['user', 'schedule'])
            ->whereHas('schedule', function($q) use ($psikolog) {
                $q->where('psikolog_id', $psikolog->id)
                  ->where('date', '>=', now()->toDateString());
            })
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('psikolog.dashboard', compact(
            'psikolog',
            'pendingBookings',
            'todaySchedules',
            'totalConsultations',
            'upcomingBookings'
        ));
    }
}
