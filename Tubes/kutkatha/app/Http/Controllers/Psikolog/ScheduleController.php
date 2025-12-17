<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $psikolog = Auth::user()->psikolog;

        $query = Schedule::where('psikolog_id', $psikolog->id)
            ->with('bookings.user');

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('type')) {
            $query->where('consultation_type', $request->type);
        }

        $schedules = $query->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->paginate(15);

        return view('psikolog.schedule.index', compact('schedules'));
    }

    public function create()
    {
        return view('psikolog.schedule.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'consultation_type' => 'required|in:online,offline,chat',
            'location' => 'required_if:consultation_type,offline|nullable|string',
        ]);

        $psikolog = Auth::user()->psikolog;

        // Check for overlapping schedules
        $overlap = Schedule::where('psikolog_id', $psikolog->id)
            ->where('date', $request->date)
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'Jadwal bertumpuk dengan jadwal yang sudah ada.')
                ->withInput();
        }

        Schedule::create([
            'psikolog_id' => $psikolog->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'consultation_type' => $request->consultation_type,
            'location' => $request->location,
            'is_available' => true,
        ]);

        return redirect()->route('psikolog.schedule.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $this->authorize('update', $schedule);

        return view('psikolog.schedule.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorize('update', $schedule);

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'consultation_type' => 'required|in:online,offline,chat',
            'location' => 'required_if:consultation_type,offline|nullable|string',
        ]);

        if ($schedule->isBooked()) {
            return back()->with('error', 'Tidak dapat mengubah jadwal yang sudah dibooking.');
        }

        $schedule->update([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'consultation_type' => $request->consultation_type,
            'location' => $request->location,
        ]);

        return redirect()->route('psikolog.schedule.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorize('delete', $schedule);

        if ($schedule->isBooked()) {
            return back()->with('error', 'Tidak dapat menghapus jadwal yang sudah dibooking.');
        }

        $schedule->delete();

        return redirect()->route('psikolog.schedule.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
