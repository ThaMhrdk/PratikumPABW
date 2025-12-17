@extends('layouts.main')

@section('title', 'Detail Lowongan')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-briefcase"></i> Detail Lowongan
    </h1>
    <a href="{{ route('lowongan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> {{ $lowongan->posisi }}</h3>
    </div>
    <div class="card-body">
        <div class="job-meta mb-3">
            <div class="job-meta-item">
                <i class="fas fa-building"></i>
                <span>{{ $lowongan->perusahaan }}</span>
            </div>
            <div class="job-meta-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>{{ $lowongan->lokasi_kerja }}</span>
            </div>
            @if($lowongan->gaji)
            <div class="job-meta-item">
                <i class="fas fa-money-bill-wave"></i>
                <span class="text-success">Rp {{ number_format($lowongan->gaji, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="job-meta-item">
                <i class="fas fa-calendar"></i>
                <span>Diposting: {{ $lowongan->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <hr>

        <h4 class="mb-2"><i class="fas fa-file-alt"></i> Deskripsi Pekerjaan</h4>
        <div style="white-space: pre-line; line-height: 1.8;">
            {{ $lowongan->deskripsi ?? 'Tidak ada deskripsi.' }}
        </div>
    </div>
    <div class="card-footer d-flex gap-2">
        @if(Auth::user()->role === 'pelamar')
            <a href="{{ route('lamaran.create', ['lowongan' => $lowongan->id]) }}" class="btn btn-success">
                <i class="fas fa-paper-plane"></i> Lamar Sekarang
            </a>
        @else
            <a href="{{ route('lowongan.edit', $lowongan) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('lowongan.destroy', $lowongan) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
