@extends('jobfinder::layouts.main')

@section('title', 'Detail Lamaran')

@section('content')
<div class="page-header">
    <h1>Detail Lamaran</h1>
    <a href="{{ route('jobfinder.lamaran.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="grid grid-2">
    <div class="card">
        <div class="card-header"><i class="fas fa-user"></i> Pelamar</div>
        <div class="card-body">
            <div class="detail-grid">
                <span class="detail-label">Nama</span>
                <span class="detail-value"><strong>{{ $lamaran->user->name }}</strong></span>
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $lamaran->user->email }}</span>
                <span class="detail-label">Tanggal Melamar</span>
                <span class="detail-value">{{ $lamaran->created_at->format('d M Y, H:i') }}</span>
                <span class="detail-label">CV</span>
                <span class="detail-value">
                    @if($lamaran->cv_file)
                        <a href="{{ route('jobfinder.lamaran.download-cv', $lamaran) }}" class="btn btn-outline btn-sm"><i class="fas fa-download"></i> Unduh</a>
                    @else
                        <span class="text-muted">Tidak ada</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-briefcase"></i> Lowongan</div>
        <div class="card-body">
            <div class="detail-grid">
                <span class="detail-label">Posisi</span>
                <span class="detail-value"><strong>{{ $lamaran->lowongan->posisi }}</strong></span>
                <span class="detail-label">Perusahaan</span>
                <span class="detail-value">{{ $lamaran->lowongan->perusahaan }}</span>
                <span class="detail-label">Lokasi</span>
                <span class="detail-value">{{ $lamaran->lowongan->lokasi_kerja }}</span>
                <span class="detail-label">Gaji</span>
                <span class="detail-value">
                    @if($lamaran->lowongan->gaji)
                        <span class="badge badge-success">Rp {{ number_format($lamaran->lowongan->gaji, 0, ',', '.') }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header"><i class="fas fa-comment"></i> Surat Pengantar</div>
    <div class="card-body">
        <div style="white-space: pre-line; line-height: 1.8;">{{ $lamaran->deskripsi_lamaran }}</div>
    </div>
</div>

@php /** @var \App\Models\User $user */ $user = Auth::user(); @endphp
<div class="mt-3 actions">
    @if($user->role === 'pelamar' && $lamaran->user_id === Auth::id())
        <a href="{{ route('jobfinder.lamaran.edit', $lamaran) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    @endif
    @if($user->role === 'admin')
        <button class="btn btn-danger" onclick="hapusLamaran({{ $lamaran->id }})"><i class="fas fa-trash"></i> Hapus</button>
    @endif
</div>
@endsection

@push('scripts')
<script>
function hapusLamaran(id) {
    Swal.fire({
        title: 'Hapus Lamaran?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/module/lamaran/' + id,
                type: 'DELETE',
                success: function() {
                    Swal.fire('Berhasil!', 'Lamaran dihapus.', 'success').then(() => {
                        window.location.href = '{{ route("jobfinder.lamaran.index") }}';
                    });
                }
            });
        }
    });
}
</script>
@endpush
