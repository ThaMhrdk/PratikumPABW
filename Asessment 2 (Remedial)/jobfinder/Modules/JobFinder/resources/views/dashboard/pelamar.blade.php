@extends('jobfinder::layouts.main')

@section('title', 'Dashboard')

@section('content')
@php /** @var \App\Models\User $user */ $user = Auth::user(); @endphp
<div class="page-header">
    <h1>Selamat Datang, {{ $user->name }}!</h1>
    <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-primary">
        <i class="fas fa-search"></i> Cari Lowongan
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $statistik['total_lowongan'] }}</h3>
        <p><i class="fas fa-briefcase"></i> Lowongan Tersedia</p>
    </div>
    <div class="stat-card">
        <h3>{{ $statistik['lamaran_saya'] }}</h3>
        <p><i class="fas fa-paper-plane"></i> Lamaran Terkirim</p>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-header"><i class="fas fa-fire"></i> Lowongan Terbaru</div>
        <div class="card-body">
            @forelse($lowonganTerbaru as $lowongan)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <strong>{{ $lowongan->posisi }}</strong>
                            <p class="text-muted" style="font-size: 0.8rem; margin: 0.25rem 0;">{{ $lowongan->perusahaan }}</p>
                            @if($lowongan->gaji)
                                <span class="badge badge-success">Rp {{ number_format($lowongan->gaji, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('jobfinder.lamaran.create', ['lowongan' => $lowongan->id]) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-paper-plane"></i>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Belum ada lowongan</p>
            @endforelse
            <div class="mt-2">
                <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-outline btn-sm">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-file-alt"></i> Lamaran Saya</div>
        <div class="card-body">
            @forelse($lamaranSayaTerbaru as $lamaran)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ $lamaran->lowongan->posisi }}</strong>
                        <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $lamaran->lowongan->perusahaan }}</p>
                    </div>
                    <span class="badge badge-{{ $lamaran->status === 'diterima' ? 'success' : ($lamaran->status === 'ditolak' ? 'danger' : 'warning') }}">{{ ucfirst($lamaran->status) }}</span>
                </div>
            @empty
                <p class="text-muted text-center">Belum ada lamaran</p>
            @endforelse
            <div class="mt-2">
                <a href="{{ route('jobfinder.lamaran.index') }}" class="btn btn-outline btn-sm">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection
