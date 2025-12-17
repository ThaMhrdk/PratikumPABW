@extends('layouts.dashboard')

@section('title', 'Cari Psikolog')
@section('page-title', 'Cari Psikolog')

@section('sidebar')
    @include('user.partials.sidebar')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('user.psikolog.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Cari Nama</label>
                <input type="text" name="search" class="form-control" placeholder="Nama psikolog..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Spesialisasi</label>
                <select name="specialization" class="form-select">
                    <option value="">Semua Spesialisasi</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>
                            {{ $spec }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipe Konsultasi</label>
                <select name="consultation_type" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="online" {{ request('consultation_type') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('consultation_type') == 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="chat" {{ request('consultation_type') == 'chat' ? 'selected' : '' }}>Chat</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</div>

@if($psikologs->count() > 0)
    <div class="row g-4">
        @foreach($psikologs as $psikolog)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <img src="{{ $psikolog->user->photo_url }}" alt="{{ $psikolog->user->name }}"
                         class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="card-title mb-1">{{ $psikolog->user->name }}</h5>
                    <p class="text-primary-custom mb-2">{{ $psikolog->specialization }}</p>

                    <div class="d-flex justify-content-center gap-3 mb-3 small text-muted">
                        <span><i class="fas fa-briefcase me-1"></i>{{ $psikolog->experience_years }} thn</span>
                        <span><i class="fas fa-star text-warning me-1"></i>{{ $psikolog->average_rating }}</span>
                        <span><i class="fas fa-users me-1"></i>{{ $psikolog->total_consultations }}</span>
                    </div>

                    <p class="text-muted small mb-3">{{ Str::limit($psikolog->bio, 80) }}</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-primary-custom">
                            Rp {{ number_format($psikolog->consultation_fee, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('user.psikolog.show', $psikolog) }}" class="btn btn-primary btn-sm">
                            Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $psikologs->links() }}
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-user-md fa-4x text-muted mb-3"></i>
            <h5>Tidak ada psikolog ditemukan</h5>
            <p class="text-muted">Coba ubah filter pencarian Anda</p>
        </div>
    </div>
@endif
@endsection
