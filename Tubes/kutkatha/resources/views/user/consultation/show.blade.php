@extends('layouts.dashboard')

@section('title', 'Detail Konsultasi')
@section('page-title', 'Detail Konsultasi')

@section('sidebar')
    @include('user.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Konsultasi</h5>
                @if($consultation->isCompleted())
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-warning">Berlangsung</span>
                @endif
            </div>
            <div class="card-body">
                <h6 class="text-muted">Keluhan Awal</h6>
                <p>{{ $consultation->booking->complaint }}</p>

                @if($consultation->isCompleted())
                <hr>

                <h6 class="text-muted">Ringkasan Konsultasi</h6>
                <p>{{ $consultation->summary }}</p>

                @if($consultation->diagnosis)
                <h6 class="text-muted">Diagnosis</h6>
                <p>{{ $consultation->diagnosis }}</p>
                @endif

                <h6 class="text-muted">Rekomendasi</h6>
                <p>{{ $consultation->recommendation }}</p>

                @if($consultation->follow_up_notes)
                <h6 class="text-muted">Catatan Tindak Lanjut</h6>
                <p>{{ $consultation->follow_up_notes }}</p>
                @endif

                @if($consultation->next_session_date)
                <div class="alert alert-info">
                    <i class="fas fa-calendar me-2"></i>
                    Sesi berikutnya dijadwalkan: <strong>{{ $consultation->next_session_date->format('d M Y') }}</strong>
                </div>
                @endif
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-hourglass-half me-2"></i>
                    Konsultasi sedang berlangsung. Hasil akan tersedia setelah sesi selesai.
                </div>

                @if($consultation->booking->schedule->consultation_type == 'chat')
                <a href="{{ route('user.consultation.chat', $consultation) }}" class="btn btn-primary">
                    <i class="fas fa-comments me-2"></i>Buka Chat
                </a>
                @endif
                @endif
            </div>
        </div>

        @if($consultation->isCompleted() && !$consultation->feedback)
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Beri Feedback</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.consultation.feedback.store', $consultation) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <div class="rating-input" id="rating-input">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-muted rating-star" data-rating="{{ $i }}"
                               style="cursor: pointer; font-size: 1.5rem;"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-value" required>
                        @error('rating')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Komentar (Opsional)</label>
                        <textarea name="comment" class="form-control" rows="3"
                                  placeholder="Bagikan pengalaman konsultasi Anda...">{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Feedback
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($consultation->feedback)
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Feedback Anda</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    {!! $consultation->feedback->stars_html !!}
                    <span class="ms-2">({{ $consultation->feedback->rating }}/5)</span>
                </div>
                @if($consultation->feedback->comment)
                <p class="mb-0">{{ $consultation->feedback->comment }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Psikolog</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $consultation->booking->schedule->psikolog->user->photo_url }}"
                     alt="" class="rounded-circle mb-3"
                     style="width: 100px; height: 100px; object-fit: cover;">
                <h5>{{ $consultation->booking->schedule->psikolog->user->name }}</h5>
                <p class="text-primary-custom">{{ $consultation->booking->schedule->psikolog->specialization }}</p>
                <a href="{{ route('user.psikolog.show', $consultation->booking->schedule->psikolog) }}"
                   class="btn btn-sm btn-outline-primary">
                    Lihat Profil
                </a>
            </div>
        </div>

        <div class="card">
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
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tipe</span>
                    <span>{{ $consultation->booking->schedule->consultation_type_name }}</span>
                </div>
                @if($consultation->duration)
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Durasi</span>
                    <span>{{ $consultation->duration }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.rating-star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        document.getElementById('rating-value').value = rating;

        document.querySelectorAll('.rating-star').forEach((s, index) => {
            if (index < rating) {
                s.classList.remove('text-muted');
                s.classList.add('text-warning');
            } else {
                s.classList.add('text-muted');
                s.classList.remove('text-warning');
            }
        });
    });

    star.addEventListener('mouseenter', function() {
        const rating = this.dataset.rating;
        document.querySelectorAll('.rating-star').forEach((s, index) => {
            if (index < rating) {
                s.classList.add('text-warning');
            }
        });
    });

    star.addEventListener('mouseleave', function() {
        const currentRating = document.getElementById('rating-value').value || 0;
        document.querySelectorAll('.rating-star').forEach((s, index) => {
            if (index >= currentRating) {
                s.classList.remove('text-warning');
                s.classList.add('text-muted');
            }
        });
    });
});
</script>
@endpush
@endsection
