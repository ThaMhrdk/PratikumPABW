@extends('layouts.dashboard')

@section('title', 'Riwayat Konsultasi')
@section('page-title', 'Riwayat Konsultasi')

@section('sidebar')
    @include('user.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Konsultasi Saya</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('user.consultation.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>

        @if($consultations->count() > 0)
            @foreach($consultations as $consultation)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex">
                            <img src="{{ $consultation->booking->schedule->psikolog->user->photo_url }}"
                                 alt="" class="rounded-circle me-3"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1">{{ $consultation->booking->schedule->psikolog->user->name }}</h5>
                                <p class="text-muted mb-0">{{ $consultation->booking->schedule->psikolog->specialization }}</p>
                            </div>
                        </div>
                        @if($consultation->isCompleted())
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-warning">Berlangsung</span>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small class="text-muted">Tanggal</small>
                            <p class="mb-0">{{ $consultation->booking->schedule->date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Waktu</small>
                            <p class="mb-0">{{ $consultation->booking->schedule->formatted_time }}</p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Tipe</small>
                            <p class="mb-0">{{ $consultation->booking->schedule->consultation_type_name }}</p>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('user.consultation.show', $consultation) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>Detail
                        </a>
                        @if(!$consultation->isCompleted() && $consultation->booking->schedule->consultation_type == 'chat')
                            <a href="{{ route('user.consultation.chat', $consultation) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-comments me-2"></i>Buka Chat
                            </a>
                        @endif
                        @if($consultation->isCompleted() && !$consultation->feedback)
                            <a href="{{ route('user.consultation.feedback', $consultation) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-star me-2"></i>Beri Feedback
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            {{ $consultations->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                <h5>Belum ada konsultasi</h5>
                <p class="text-muted">Riwayat konsultasi Anda akan muncul di sini</p>
                <a href="{{ route('user.psikolog.index') }}" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>Cari Psikolog
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
