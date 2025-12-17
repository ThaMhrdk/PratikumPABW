@extends('layouts.main')

@section('title', 'Dashboard Pelamar')

@section('content')
<div class="dashboard-header">
    <h1><i class="fas fa-home"></i> Dashboard</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Temukan pekerjaan impian Anda di Kabupaten Bandung.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalLowongan }}</h3>
            <p>Lowongan Tersedia</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-paper-plane"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $myLamaran }}</h3>
            <p>Lamaran Saya</p>
        </div>
    </div>
</div>

<div class="d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
    <!-- Recent Lowongan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-briefcase"></i> Lowongan Terbaru</h3>
        </div>
        <div class="card-body">
            @forelse($recentLowongan as $lowongan)
                <div class="d-flex justify-between align-center mb-2" style="padding: 0.75rem; background: var(--bg-primary); border-radius: var(--border-radius-sm);">
                    <div>
                        <strong>{{ $lowongan->posisi }}</strong>
                        <p class="text-secondary" style="font-size: 0.85rem; margin: 0;">{{ $lowongan->perusahaan }} - {{ $lowongan->lokasi_kerja }}</p>
                        @if($lowongan->gaji)
                            <span class="text-success" style="font-size: 0.85rem;">Rp {{ number_format($lowongan->gaji, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <a href="{{ route('lamaran.create', ['lowongan' => $lowongan->id]) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-paper-plane"></i> Lamar
                    </a>
                </div>
            @empty
                <p class="text-secondary text-center">Belum ada lowongan tersedia.</p>
            @endforelse
        </div>
        <div class="card-footer">
            <a href="{{ route('lowongan.index') }}" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-search"></i> Lihat Semua Lowongan
            </a>
        </div>
    </div>

    <!-- My Recent Lamaran -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-file-alt"></i> Lamaran Saya</h3>
        </div>
        <div class="card-body">
            @forelse($myRecentLamaran as $lamaran)
                <div class="d-flex justify-between align-center mb-2" style="padding: 0.75rem; background: var(--bg-primary); border-radius: var(--border-radius-sm);">
                    <div>
                        <strong>{{ $lamaran->lowongan->posisi }}</strong>
                        <p class="text-secondary" style="font-size: 0.85rem; margin: 0;">{{ $lamaran->lowongan->perusahaan }}</p>
                        <span class="badge badge-pelamar" style="font-size: 0.7rem;">{{ $lamaran->created_at->format('d M Y') }}</span>
                    </div>
                    <a href="{{ route('lamaran.show', $lamaran) }}" class="btn btn-sm btn-outline">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            @empty
                <p class="text-secondary text-center">Anda belum melamar pekerjaan.</p>
            @endforelse
        </div>
        <div class="card-footer">
            <a href="{{ route('lamaran.index') }}" class="btn btn-secondary btn-sm w-100">
                <i class="fas fa-list"></i> Lihat Semua Lamaran Saya
            </a>
        </div>
    </div>
</div>
@endsection
