@extends('layouts.main')

@section('title', 'Detail Lamaran')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-file-alt"></i> Detail Lamaran
    </h1>
    <a href="{{ route('lamaran.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
    <!-- Lamaran Info -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user"></i> Informasi Pelamar</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="text-secondary">Nama Pelamar</label>
                <p><strong>{{ $lamaran->user->name }}</strong></p>
            </div>
            <div class="mb-3">
                <label class="text-secondary">Email</label>
                <p>{{ $lamaran->user->email }}</p>
            </div>
            <div class="mb-3">
                <label class="text-secondary">Tanggal Melamar</label>
                <p>{{ $lamaran->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="mb-3">
                <label class="text-secondary">File CV</label>
                @if($lamaran->cv_file)
                    <p>
                        <a href="{{ route('lamaran.download-cv', $lamaran) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-download"></i> Download CV
                        </a>
                    </p>
                @else
                    <p class="text-secondary">Tidak ada file CV</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Lowongan Info -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-briefcase"></i> Informasi Lowongan</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="text-secondary">Posisi</label>
                <p><strong>{{ $lamaran->lowongan->posisi }}</strong></p>
            </div>
            <div class="mb-3">
                <label class="text-secondary">Perusahaan</label>
                <p>{{ $lamaran->lowongan->perusahaan }}</p>
            </div>
            <div class="mb-3">
                <label class="text-secondary">Lokasi Kerja</label>
                <p>{{ $lamaran->lowongan->lokasi_kerja }}</p>
            </div>
            @if($lamaran->lowongan->gaji)
            <div class="mb-3">
                <label class="text-secondary">Gaji</label>
                <p class="text-success"><strong>Rp {{ number_format($lamaran->lowongan->gaji, 0, ',', '.') }}</strong></p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Deskripsi Lamaran -->
<div class="card mt-3">
    <div class="card-header">
        <h3><i class="fas fa-comment-alt"></i> Deskripsi Lamaran</h3>
    </div>
    <div class="card-body">
        <div style="white-space: pre-line; line-height: 1.8;">
            {{ $lamaran->deskripsi_lamaran }}
        </div>
    </div>
    <div class="card-footer d-flex gap-2">
        @if(Auth::user()->role === 'pelamar' && $lamaran->user_id === Auth::id())
            <a href="{{ route('lamaran.edit', $lamaran) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Lamaran
            </a>
        @endif
        @if(Auth::user()->role === 'admin')
            <button type="button" class="btn btn-danger" onclick="deleteLamaran({{ $lamaran->id }})">
                <i class="fas fa-trash"></i> Hapus Lamaran
            </button>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteLamaran(id) {
    Swal.fire({
        title: 'Hapus Lamaran?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#7f8c8d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/lamaran/' + id,
                type: 'DELETE',
                success: function(response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = '{{ route("lamaran.index") }}';
                    });
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                }
            });
        }
    });
}
</script>
@endpush
