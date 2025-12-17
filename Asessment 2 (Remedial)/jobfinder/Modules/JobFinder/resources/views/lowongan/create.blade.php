@extends('jobfinder::layouts.main')

@section('title', 'Tambah Lowongan')

@section('content')
<div class="page-header">
    <h1>Tambah Lowongan Baru</h1>
    <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form id="formTambah" action="{{ route('jobfinder.lowongan.store') }}" method="POST">
            @csrf
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Posisi *</label>
                    <input type="text" name="posisi" class="form-control" value="{{ old('posisi') }}" placeholder="Web Developer" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Perusahaan *</label>
                    <input type="text" name="perusahaan" class="form-control" value="{{ old('perusahaan') }}" placeholder="PT Teknologi Bandung" required>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="form-group">
                    <label class="form-label">Lokasi Kerja *</label>
                    <input type="text" name="lokasi_kerja" class="form-control" value="{{ old('lokasi_kerja') }}" placeholder="Soreang, Kab. Bandung" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gaji</label>
                    <input type="number" name="gaji" class="form-control" value="{{ old('gaji') }}" placeholder="5000000" min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5" placeholder="Deskripsi pekerjaan, kualifikasi, dll...">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{ route('jobfinder.lowongan.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#formTambah').on('submit', function(e) {
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
