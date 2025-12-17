@extends('jobfinder::layouts.main')

@section('title', 'Detail Lowongan')

@section('content')
<div class="page-header">
    <h1>{{ $lowongan->posisi }}</h1>
    <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-header"><i class="fas fa-info-circle"></i> Informasi</div>
        <div class="card-body">
            <div class="detail-grid">
                <span class="detail-label">Perusahaan</span>
                <span class="detail-value">{{ $lowongan->perusahaan }}</span>
                
                <span class="detail-label">Lokasi</span>
                <span class="detail-value">{{ $lowongan->lokasi_kerja }}</span>
                
                <span class="detail-label">Gaji</span>
                <span class="detail-value">
                    @if($lowongan->gaji)
                        <span class="badge badge-success">Rp {{ number_format($lowongan->gaji, 0, ',', '.') }}</span>
                    @else
                        <span class="text-muted">Tidak disebutkan</span>
                    @endif
                </span>
                
                <span class="detail-label">Diposting</span>
                <span class="detail-value">{{ $lowongan->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header"><i class="fas fa-file-alt"></i> Deskripsi</div>
        <div class="card-body">
            <div style="white-space: pre-line; line-height: 1.8;">
                {{ $lowongan->deskripsi ?? 'Tidak ada deskripsi.' }}
            </div>
        </div>
    </div>
</div>

@php /** @var \App\Models\User $user */ $user = Auth::user(); @endphp
<div class="mt-3 actions">
    @if($user->role === 'pelamar')
        <a href="{{ route('jobfinder.lamaran.create', ['lowongan' => $lowongan->id]) }}" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Kirim Lamaran
        </a>
    @else
        <a href="{{ route('jobfinder.lowongan.edit', $lowongan) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('jobfinder.lowongan.destroy', $lowongan) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus lowongan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
        </form>
    @endif
</div>
@endsection
