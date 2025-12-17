<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Feedback;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['booking.schedule.psikolog.user'])
            ->whereHas('booking', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.consultation.index', compact('consultations'));
    }

    public function show(Consultation $consultation)
    {
        $this->authorize('view', $consultation);

        $consultation->load(['booking.schedule.psikolog.user', 'feedback', 'chatMessages.sender']);

        return view('user.consultation.show', compact('consultation'));
    }

    public function chat(Consultation $consultation)
    {
        $this->authorize('view', $consultation);

        $consultation->load(['booking.schedule.psikolog.user', 'chatMessages.sender']);

        return view('user.consultation.chat', compact('consultation'));
    }

    public function sendMessage(Request $request, Consultation $consultation)
    {
        $this->authorize('view', $consultation);

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

    public function feedback(Consultation $consultation)
    {
        $this->authorize('view', $consultation);

        if ($consultation->feedback) {
            return redirect()->route('user.consultation.show', $consultation)
                ->with('info', 'Anda sudah memberikan feedback.');
        }

        $consultation->load('booking.schedule.psikolog.user');

        return view('user.consultation.feedback', compact('consultation'));
    }

    public function storeFeedback(Request $request, Consultation $consultation)
    {
        $this->authorize('view', $consultation);

        if ($consultation->feedback) {
            return back()->with('error', 'Feedback sudah diberikan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        Feedback::create([
            'consultation_id' => $consultation->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        return redirect()->route('user.consultation.show', $consultation)
            ->with('success', 'Terima kasih atas feedback Anda!');
    }
}
