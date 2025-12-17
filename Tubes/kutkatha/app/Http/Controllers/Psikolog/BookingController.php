<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $psikolog = Auth::user()->psikolog;

        $query = Booking::with(['user', 'schedule', 'payment'])
            ->whereHas('schedule', function($q) use ($psikolog) {
                $q->where('psikolog_id', $psikolog->id);
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('psikolog.booking.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $psikolog = Auth::user()->psikolog;
        if ($booking->schedule->psikolog_id !== $psikolog->id) {
            abort(403, 'Unauthorized');
        }

        $booking->load(['user', 'schedule', 'payment', 'consultation']);

        return view('psikolog.booking.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $psikolog = Auth::user()->psikolog;
        if ($booking->schedule->psikolog_id !== $psikolog->id) {
            abort(403, 'Unauthorized');
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak dapat dikonfirmasi.');
        }

        $booking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $psikolog = Auth::user()->psikolog;
        if ($booking->schedule->psikolog_id !== $psikolog->id) {
            abort(403, 'Unauthorized');
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking tidak dapat ditolak.');
        }

        $request->validate([
            'cancel_reason' => 'required|string|min:10',
        ]);

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancel_reason' => $request->cancel_reason,
        ]);

        // Make schedule available again
        $booking->schedule->update(['is_available' => true]);

        return back()->with('success', 'Booking berhasil ditolak.');
    }
}
