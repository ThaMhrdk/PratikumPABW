@extends('layouts.dashboard')

@section('title', 'Konsultasi')
@section('page-title', 'Detail Konsultasi')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Konsultasi</h5>
                @if($consultation->isCompleted())
                    <span class="badge bg-success">Selesai</span>
                @else
                    <span class="badge bg-warning">Berlangsung</span>
                @endif
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-2">Keluhan Pasien</h6>
                <div class="bg-light p-3 rounded mb-4">
                    {{ $consultation->booking->complaint }}
                </div>

                @if($consultation->booking->schedule->consultation_type == 'chat')
                <a href="{{ route('psikolog.consultation.chat', $consultation) }}" class="btn btn-primary mb-4">
                    <i class="fas fa-comments me-2"></i>Buka Chat
                </a>
                @endif

                @if(!$consultation->isCompleted())
                <hr>
                <h5>Selesaikan Konsultasi</h5>
                <form action="{{ route('psikolog.consultation.complete', $consultation) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Ringkasan Konsultasi <span class="text-danger">*</span></label>
                        <textarea name="summary" class="form-control @error('summary') is-invalid @enderror"
                                  rows="4" required>{{ old('summary') }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" class="form-control" rows="3">{{ old('diagnosis') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rekomendasi <span class="text-danger">*</span></label>
                        <textarea name="recommendation" class="form-control @error('recommendation') is-invalid @enderror"
                                  rows="4" required>{{ old('recommendation') }}</textarea>
                        @error('recommendation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Tindak Lanjut</label>
                        <textarea name="follow_up_notes" class="form-control" rows="3">{{ old('follow_up_notes') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Tanggal Sesi Berikutnya (Opsional)</label>
                        <input type="date" name="next_session_date" class="form-control"
                               value="{{ old('next_session_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Selesaikan & Kirim Hasil
                    </button>
                </form>
                @else
                <h6 class="text-muted">Ringkasan</h6>
                <p>{{ $consultation->summary }}</p>

                @if($consultation->diagnosis)
                <h6 class="text-muted">Diagnosis</h6>
                <p>{{ $consultation->diagnosis }}</p>
                @endif

                <h6 class="text-muted">Rekomendasi</h6>
                <p>{{ $consultation->recommendation }}</p>

                @if($consultation->feedback)
                <hr>
                <h6 class="text-muted">Feedback dari Pasien</h6>
                <div class="d-flex align-items-center mb-2">
                    {!! $consultation->feedback->stars_html !!}
                    <span class="ms-2">({{ $consultation->feedback->rating }}/5)</span>
                </div>
                @if($consultation->feedback->comment)
                <p class="mb-0">{{ $consultation->feedback->comment }}</p>
                @endif
                @endif
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Info Pasien</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $consultation->booking->user->photo_url }}" alt="" class="rounded-circle mb-2"
                     style="width: 80px; height: 80px; object-fit: cover;">
                <h5 class="mb-1">{{ $consultation->booking->user->name }}</h5>
                <p class="text-muted small">{{ $consultation->booking->user->email }}</p>
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
@endsection
