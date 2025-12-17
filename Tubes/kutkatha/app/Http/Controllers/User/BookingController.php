<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['schedule.psikolog.user', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.booking.index', compact('bookings'));
    }

    public function create(Schedule $schedule)
    {
        if (!$schedule->is_available || $schedule->isBooked()) {
            return back()->with('error', 'Jadwal tidak tersedia.');
        }

        $schedule->load('psikolog.user');

        return view('user.booking.create', compact('schedule'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'complaint' => 'required|string|min:10',
            'notes' => 'nullable|string',
        ]);

        $schedule = Schedule::with('psikolog')->findOrFail($request->schedule_id);

        if (!$schedule->is_available || $schedule->isBooked()) {
            return back()->with('error', 'Jadwal tidak tersedia.');
        }

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'schedule_id' => $schedule->id,
                'complaint' => $request->complaint,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $schedule->psikolog->consultation_fee,
                'status' => 'pending',
            ]);

            // Mark schedule as unavailable
            $schedule->update(['is_available' => false]);

            DB::commit();

            return redirect()->route('user.booking.payment', $booking)
                ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $booking->load(['schedule.psikolog.user', 'payment', 'consultation']);

        return view('user.booking.show', compact('booking'));
    }

    public function payment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($booking->isPaid()) {
            return redirect()->route('user.booking.show', $booking)
                ->with('info', 'Pembayaran sudah dilakukan.');
        }

        $booking->load(['schedule.psikolog.user', 'payment']);

        return view('user.booking.payment', compact('booking'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'payment_method' => 'required|in:transfer,ewallet,cash',
            'proof_of_payment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $proofPath = $request->file('proof_of_payment')->store('payments', 'public');

        $booking->payment->update([
            'payment_method' => $request->payment_method,
            'proof_of_payment' => $proofPath,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('user.booking.show', $booking)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function cancel(Booking $booking, Request $request)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'Booking tidak dapat dibatalkan.');
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

        return redirect()->route('user.booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
