<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Booking;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $psikolog = Auth::user()->psikolog;

        $consultations = Consultation::with(['booking.user', 'booking.schedule'])
            ->whereHas('booking.schedule', function($q) use ($psikolog) {
                $q->where('psikolog_id', $psikolog->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('psikolog.consultation.index', compact('consultations'));
    }

    public function start(Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Booking belum dikonfirmasi.');
        }

        if (!$booking->isPaid()) {
            return back()->with('error', 'Pembayaran belum dilakukan.');
        }

        $consultation = Consultation::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'status' => 'ongoing',
                'started_at' => now(),
            ]
        );

        return redirect()->route('psikolog.consultation.show', $consultation);
    }

    public function show(Consultation $consultation)
    {
        $this->authorize('manage', $consultation);

        $consultation->load(['booking.user', 'booking.schedule', 'chatMessages.sender', 'feedback']);

        return view('psikolog.consultation.show', compact('consultation'));
    }

    public function chat(Consultation $consultation)
    {
        $this->authorize('manage', $consultation);

        $consultation->load(['booking.user', 'booking.schedule', 'chatMessages.sender']);

        return view('psikolog.consultation.chat', compact('consultation'));
    }

    public function sendMessage(Request $request, Consultation $consultation)
    {
        $this->authorize('manage', $consultation);

        $request->validate([
            'message' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat-attachments', 'public');
        }

        ChatMessage::create([
            'consultation_id' => $consultation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'attachment' => $attachmentPath,
        ]);

        return back()->with('success', 'Pesan terkirim!');
    }

    public function complete(Request $request, Consultation $consultation)
    {
        $this->authorize('manage', $consultation);

        $request->validate([
            'summary' => 'required|string|min:20',
            'diagnosis' => 'nullable|string',
            'recommendation' => 'required|string|min:20',
            'follow_up_notes' => 'nullable|string',
            'next_session_date' => 'nullable|date|after:today',
        ]);

        $consultation->update([
            'summary' => $request->summary,
            'diagnosis' => $request->diagnosis,
            'recommendation' => $request->recommendation,
            'follow_up_notes' => $request->follow_up_notes,
            'next_session_date' => $request->next_session_date,
            'status' => 'completed',
            'ended_at' => now(),
        ]);

        $consultation->booking->update(['status' => 'completed']);

        return redirect()->route('psikolog.consultation.index')
            ->with('success', 'Konsultasi selesai. Hasil telah dikirim ke user.');
    }
}
