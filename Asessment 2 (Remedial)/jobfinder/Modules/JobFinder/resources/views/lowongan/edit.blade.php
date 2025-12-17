@extends('jobfinder::layouts.main')

@section('title', 'Edit Lowongan')

@section('content')
<div class="page-header">
    <h1>Edit Lowongan</h1>
    <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form id="formEdit" action="{{ route('jobfinder.lowongan.update', $lowongan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Posisi *</label>
                    <input type="text" name="posisi" class="form-control" value="{{ old('posisi', $lowongan->posisi) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Perusahaan *</label>
                    <input type="text" name="perusahaan" class="form-control" value="{{ old('perusahaan', $lowongan->perusahaan) }}" required>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Lokasi Kerja *</label>
                    <input type="text" name="lokasi_kerja" class="form-control" value="{{ old('lokasi_kerja', $lowongan->lokasi_kerja) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gaji</label>
                    <input type="number" name="gaji" class="form-control" value="{{ old('gaji', $lowongan->gaji) }}" min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#formEdit').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(res) {
            Swal.fire('Berhasil!', res.message, 'success').then(() => {
                window.location.href = '{{ route("jobfinder.lowongan.index") }}';
            });
        },
        error: function(xhr) {
            var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
            Swal.fire('Gagal!', msg, 'error');
        }
    });
});
</script>
@endpush
