<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\Psikolog;
use App\Models\Consultation;
use App\Models\Booking;

use App\Models\Feedback;
use App\Models\Article;
use App\Models\ForumTopic;
use App\Models\ForumPost;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalPsikologs = Psikolog::where('verification_status', 'verified')->count();
        $activePsikologs = $totalPsikologs; // Alias for view compatibility
        $totalConsultations = Consultation::where('status', 'completed')->count();

        // Calculate satisfaction rate
        $avgRating = Feedback::avg('rating');
        $satisfactionRate = $avgRating ? round(($avgRating / 5) * 100) : 0;

        // Consultation by type
        $onlineConsultations = Booking::whereHas('schedule', function($q) {
            $q->where('consultation_type', 'online');
        })->where('status', 'completed')->count();

        $offlineConsultations = Booking::whereHas('schedule', function($q) {
            $q->where('consultation_type', 'offline');
        })->where('status', 'completed')->count();

        $chatConsultations = Booking::whereHas('schedule', function($q) {
            $q->where('consultation_type', 'chat');
        })->where('status', 'completed')->count();

        $latestReports = Report::where('status', 'sent')
            ->orderBy('sent_at', 'desc')
            ->take(5)
            ->get();

        // Statistics for charts
        $monthlyConsultations = Consultation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $consultationsByType = Booking::selectRaw('consultation_type, COUNT(*) as count')
            ->join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->where('bookings.status', 'completed')
            ->groupBy('consultation_type')
            ->pluck('count', 'consultation_type')
            ->toArray();

        return view('pemerintah.dashboard', compact(
            'totalUsers',
            'totalPsikologs',
            'activePsikologs',
            'totalConsultations',
            'satisfactionRate',
            'onlineConsultations',
            'offlineConsultations',
            'chatConsultations',
            'latestReports',
            'monthlyConsultations',
            'consultationsByType'
        ));
    }

    public function reports()
    {
        $reports = Report::where('status', 'sent')
            ->orderBy('sent_at', 'desc')
            ->paginate(15);

        return view('pemerintah.reports', compact('reports'));
    }

    public function showReport(Report $report)
    {
        if ($report->status !== 'sent') {
            abort(404);
        }

        return view('pemerintah.report-detail', compact('report'));
    }

    public function statistics()
    {
        // User statistics
        $totalUsers = User::where('role', 'user')->count();
        $newUsersThisMonth = User::where('role', 'user')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Session statistics
        $totalSessions = Consultation::where('status', 'completed')->count();
        $newSessionsThisMonth = Consultation::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Article statistics
        $totalArticles = Article::where('status', 'published')->count();
        $totalArticleViews = Article::where('status', 'published')->sum('views_count');

        // Forum statistics
        $totalForumTopics = ForumTopic::count();
        $totalForumPosts = ForumPost::count();

        // Rating statistics
        $averageRating = Feedback::avg('rating') ?? 0;
        $totalReviews = Feedback::count();
        $ratingDistribution = [
            5 => Feedback::where('rating', 5)->count(),
            4 => Feedback::where('rating', 4)->count(),
            3 => Feedback::where('rating', 3)->count(),
            2 => Feedback::where('rating', 2)->count(),
            1 => Feedback::where('rating', 1)->count(),
        ];

        $yearlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $yearlyData[$month] = [
                'consultations' => Consultation::whereYear('created_at', now()->year)
                    ->whereMonth('created_at', $month)
                    ->where('status', 'completed')
                    ->count(),
                'new_users' => User::whereYear('created_at', now()->year)
                    ->whereMonth('created_at', $month)
                    ->where('role', 'user')
                    ->count(),
            ];
        }

        $topPsikologs = Psikolog::with('user')
            ->where('verification_status', 'verified')
            ->withCount(['schedules as completed_consultations' => function($q) {
                $q->whereHas('bookings', function($q2) {
                    $q2->where('status', 'completed');
                });
            }])
            ->orderByDesc('completed_consultations')
            ->take(10)
            ->get();

        return view('pemerintah.statistics', compact(
            'totalUsers', 'newUsersThisMonth',
            'totalSessions', 'newSessionsThisMonth',
            'totalArticles', 'totalArticleViews',
            'totalForumTopics', 'totalForumPosts',
            'averageRating', 'totalReviews', 'ratingDistribution',
            'yearlyData', 'topPsikologs'
        ));
    }
}
