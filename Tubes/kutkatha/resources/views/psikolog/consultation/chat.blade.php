@extends('layouts.dashboard')

@section('title', 'Chat Konsultasi')
@section('page-title', 'Chat Konsultasi')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@push('styles')
<style>
.chat-container {
    height: calc(100vh - 350px);
    min-height: 400px;
    display: flex;
    flex-direction: column;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    background: #f8f9fa;
}

.message {
    max-width: 70%;
    margin-bottom: 1rem;
    padding: 0.75rem 1rem;
    border-radius: 15px;
}

.message-sent {
    background: var(--primary-color);
    color: white;
    margin-left: auto;
    border-bottom-right-radius: 5px;
}

.message-received {
    background: white;
    border: 1px solid #dee2e6;
    margin-right: auto;
    border-bottom-left-radius: 5px;
}

.message-time {
    font-size: 0.75rem;
    opacity: 0.7;
}

.chat-input {
    border-top: 1px solid #dee2e6;
    padding: 1rem;
    background: white;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ $consultation->booking->user->photo_url }}" alt=""
                         class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                    <div>
                        <h6 class="mb-0">{{ $consultation->booking->user->name }}</h6>
                        <small class="text-muted">{{ $consultation->booking->schedule->formatted_time }}</small>
                    </div>
                </div>
                @if(!$consultation->isCompleted())
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeModal">
                        <i class="fas fa-check me-2"></i>Selesaikan
                    </button>
                @endif
            </div>
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    @foreach($messages as $message)
                    <div class="message {{ $message->sender_id == Auth::id() ? 'message-sent' : 'message-received' }}">
                        <p class="mb-1">{{ $message->message }}</p>
                        <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                    </div>
                    @endforeach
                </div>

                @if(!$consultation->isCompleted())
                <div class="chat-input">
                    <form action="{{ route('psikolog.consultation.send-message', $consultation) }}" method="POST" id="chatForm">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="chat-input text-center text-muted">
                    <i class="fas fa-lock me-2"></i>Konsultasi telah selesai
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Info Pasien</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-1">Nama</p>
                <p class="mb-3">{{ $consultation->booking->user->name }}</p>

                <p class="text-muted mb-1">Email</p>
                <p class="mb-3">{{ $consultation->booking->user->email }}</p>

                <p class="text-muted mb-1">Keluhan</p>
                <p class="mb-0">{{ $consultation->booking->complaint }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Notes</h5>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Catatan untuk konsultasi ini..."></textarea>
            </div>
        </div>
    </div>
</div>

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('psikolog.consultation.complete', $consultation) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Selesaikan Konsultasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Ringkasan Konsultasi <span class="text-danger">*</span></label>
                        <textarea name="summary" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rekomendasi <span class="text-danger">*</span></label>
                        <textarea name="recommendation" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Tindak Lanjut</label>
                        <textarea name="follow_up_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Selesaikan & Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Scroll to bottom on load
const chatMessages = document.getElementById('chatMessages');
chatMessages.scrollTop = chatMessages.scrollHeight;

// Auto refresh messages every 5 seconds (in real app, use WebSocket)
setInterval(function() {
    // location.reload();
}, 5000);
</script>
@endpush
@endsection
