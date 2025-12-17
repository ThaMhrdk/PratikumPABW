<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $upcomingBookings = Booking::with(['schedule.psikolog.user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereHas('schedule', function($q) {
                $q->where('date', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $completedConsultations = Consultation::whereHas('booking', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'completed')->count();

        $latestArticles = Article::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('user.dashboard', compact('upcomingBookings', 'completedConsultations', 'latestArticles'));
    }
}
