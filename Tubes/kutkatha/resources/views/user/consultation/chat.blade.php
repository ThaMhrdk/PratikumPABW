@extends('layouts.dashboard')

@section('title', 'Chat Konsultasi')
@section('page-title', 'Chat Konsultasi')

@section('sidebar')
    @include('user.partials.sidebar')
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
                    <img src="{{ $consultation->booking->schedule->psikolog->user->photo_url }}"
                         alt="" class="rounded-circle me-2"
                         style="width: 40px; height: 40px; object-fit: cover;">
                    <div>
                        <h6 class="mb-0">{{ $consultation->booking->schedule->psikolog->user->name }}</h6>
                        <small class="text-muted">{{ $consultation->booking->schedule->psikolog->specialization }}</small>
                    </div>
                </div>
                @if($consultation->isCompleted())
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-warning">Berlangsung</span>
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
                    <form action="{{ route('user.consultation.send-message', $consultation) }}" method="POST" id="chatForm">
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
                    <i class="fas fa-lock me-2"></i>Konsultasi telah selesai.
                    <a href="{{ route('user.consultation.show', $consultation) }}">Lihat hasil konsultasi</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Info Sesi</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tanggal</span>
                    <span>{{ $consultation->booking->schedule->date->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Waktu</span>
                    <span>{{ $consultation->booking->schedule->formatted_time }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Tipe</span>
                    <span>Chat</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Keluhan</h5>
            </div>
            <div class="card-body">
                <p class="mb-0 text-muted">{{ $consultation->booking->complaint }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Scroll to bottom on load
const chatMessages = document.getElementById('chatMessages');
chatMessages.scrollTop = chatMessages.scrollHeight;
</script>
@endpush
@endsection
