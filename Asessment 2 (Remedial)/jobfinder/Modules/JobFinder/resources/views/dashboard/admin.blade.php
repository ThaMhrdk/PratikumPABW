@extends('jobfinder::layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header">
    <h1>Dashboard Admin</h1>
    <a href="{{ route('jobfinder.lowongan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Lowongan
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $statistik['total_lowongan'] }}</h3>
        <p><i class="fas fa-briefcase"></i> Total Lowongan</p>
    </div>
    <div class="stat-card">
        <h3>{{ $statistik['total_lamaran'] }}</h3>
        <p><i class="fas fa-file-alt"></i> Total Lamaran</p>
    </div>
    <div class="stat-card">
        <h3>{{ $statistik['total_pelamar'] }}</h3>
        <p><i class="fas fa-users"></i> Total Pelamar</p>
    </div>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-header"><i class="fas fa-briefcase"></i> Lowongan Terbaru</div>
        <div class="card-body">
            @forelse($lowonganTerbaru as $lowongan)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ $lowongan->posisi }}</strong>
                        <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $lowongan->perusahaan }}</p>
                    </div>
                    <a href="{{ route('jobfinder.lowongan.edit', $lowongan) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
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
        <div class="card-header"><i class="fas fa-file-alt"></i> Lamaran Terbaru</div>
        <div class="card-body">
            @forelse($lamaranTerbaru as $lamaran)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>{{ $lamaran->user->name }}</strong>
                        <p class="text-muted" style="font-size: 0.8rem; margin: 0;">{{ $lamaran->lowongan->posisi }}</p>
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
