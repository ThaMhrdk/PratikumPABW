<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Psikolog;
use App\Models\Schedule;
use Illuminate\Http\Request;

class PsikologController extends Controller
{
    public function index(Request $request)
    {
        $query = Psikolog::with('user')
            ->where('verification_status', 'verified');

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        // Filter by consultation type
        if ($request->filled('consultation_type')) {
            $query->whereHas('schedules', function($q) use ($request) {
                $q->where('consultation_type', $request->consultation_type)
                  ->where('is_available', true)
                  ->where('date', '>=', now()->toDateString());
            });
        }

        // Search by name
        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $psikologs = $query->paginate(12);

        $specializations = Psikolog::where('verification_status', 'verified')
            ->distinct()
            ->pluck('specialization');

        return view('user.psikolog.index', compact('psikologs', 'specializations'));
    }

    public function show(Psikolog $psikolog)
    {
        $psikolog->load(['user', 'schedules' => function($q) {
            $q->where('date', '>=', now()->toDateString())
              ->where('is_available', true)
              ->orderBy('date')
              ->orderBy('start_time');
        }]);

        return view('user.psikolog.show', compact('psikolog'));
    }

    public function schedules(Psikolog $psikolog, Request $request)
    {
        $schedules = Schedule::where('psikolog_id', $psikolog->id)
            ->where('date', '>=', now()->toDateString())
            ->where('is_available', true)
            ->whereDoesntHave('bookings', function($q) {
                $q->whereIn('status', ['pending', 'confirmed']);
            });

        if ($request->filled('type')) {
            $schedules->where('consultation_type', $request->type);
        }

        if ($request->filled('date')) {
            $schedules->where('date', $request->date);
        }

        $schedules = $schedules->orderBy('date')->orderBy('start_time')->get();

        return response()->json($schedules);
    }
}
