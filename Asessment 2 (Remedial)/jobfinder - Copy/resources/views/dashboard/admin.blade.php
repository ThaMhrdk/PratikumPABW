@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
<div class="dashboard-header">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Kelola lowongan dan lamaran kerja di Kabupaten Bandung.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalLowongan }}</h3>
            <p>Total Lowongan</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalLamaran }}</h3>
            <p>Total Lamaran</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalPelamar }}</h3>
            <p>Total Pelamar</p>
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
                        <p class="text-secondary" style="font-size: 0.85rem; margin: 0;">{{ $lowongan->perusahaan }}</p>
                    </div>
                    <a href="{{ route('lowongan.edit', $lowongan) }}" class="btn btn-sm btn-outline">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            @empty
                <p class="text-secondary text-center">Belum ada lowongan.</p>
            @endforelse
        </div>
        <div class="card-footer">
            <a href="{{ route('lowongan.index') }}" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-list"></i> Lihat Semua Lowongan
            </a>
        </div>
    </div>

    <!-- Recent Lamaran -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-file-alt"></i> Lamaran Terbaru</h3>
        </div>
        <div class="card-body">
            @forelse($recentLamaran as $lamaran)
                <div class="d-flex justify-between align-center mb-2" style="padding: 0.75rem; background: var(--bg-primary); border-radius: var(--border-radius-sm);">
                    <div>
                        <strong>{{ $lamaran->user->name }}</strong>
                        <p class="text-secondary" style="font-size: 0.85rem; margin: 0;">{{ $lamaran->lowongan->posisi }}</p>
                    </div>
                    <a href="{{ route('lamaran.show', $lamaran) }}" class="btn btn-sm btn-outline">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            @empty
                <p class="text-secondary text-center">Belum ada lamaran.</p>
            @endforelse
        </div>
        <div class="card-footer">
            <a href="{{ route('lamaran.index') }}" class="btn btn-secondary btn-sm w-100">
                <i class="fas fa-list"></i> Lihat Semua Lamaran
            </a>
        </div>
    </div>
</div>
@endsection
