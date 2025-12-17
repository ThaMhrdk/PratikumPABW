@extends('layouts.main')

@section('title', 'Edit Lowongan')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-edit"></i> Edit Lowongan
    </h1>
    <a href="{{ route('lowongan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-briefcase"></i> Form Edit Lowongan</h3>
    </div>
    <div class="card-body">
        <form id="editForm" action="{{ route('lowongan.update', $lowongan) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="posisi" class="form-label required">Posisi</label>
                <input type="text" name="posisi" id="posisi" class="form-control @error('posisi') is-invalid @enderror" 
                       value="{{ old('posisi', $lowongan->posisi) }}" placeholder="Contoh: Web Developer" required>
                @error('posisi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="perusahaan" class="form-label required">Nama Perusahaan</label>
                <input type="text" name="perusahaan" id="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror" 
                       value="{{ old('perusahaan', $lowongan->perusahaan) }}" placeholder="Contoh: PT Teknologi Bandung" required>
                @error('perusahaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="lokasi_kerja" class="form-label required">Lokasi Kerja</label>
                <input type="text" name="lokasi_kerja" id="lokasi_kerja" class="form-control @error('lokasi_kerja') is-invalid @enderror" 
                       value="{{ old('lokasi_kerja', $lowongan->lokasi_kerja) }}" placeholder="Contoh: Soreang, Kab. Bandung" required>
                @error('lokasi_kerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="gaji" class="form-label">Gaji (Opsional)</label>
                <input type="number" name="gaji" id="gaji" class="form-control @error('gaji') is-invalid @enderror" 
                       value="{{ old('gaji', $lowongan->gaji) }}" placeholder="Contoh: 5000000" min="0">
                <div class="form-text">Masukkan dalam format angka tanpa titik atau koma</div>
                @error('gaji')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                          rows="5" placeholder="Jelaskan deskripsi pekerjaan, kualifikasi yang dibutuhkan, dll.">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Lowongan
                </button>
                <a href="{{ route('lowongan.index') }}" class="btn btn-outline">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = new FormData(this);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = '{{ route("lowongan.index") }}';
                });
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors;
                if (errors) {
                    var errorMsg = Object.values(errors).flat().join('\n');
                    Swal.fire('Error!', errorMsg, 'error');
                } else {
                    Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
                }
            }
        });
    });
});
</script>
@endpush
