@extends('jobfinder::layouts.main')

@section('title', 'Edit Lamaran')

@section('content')
<div class="page-header">
    <h1>Edit Lamaran</h1>
    <a href="{{ route('jobfinder.lamaran.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form id="formEdit" action="{{ route('jobfinder.lamaran.update', $lamaran) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Pilih Lowongan *</label>
                <select name="lowongan_id" class="form-control" required>
                    <option value="">-- Pilih Lowongan --</option>
                    @foreach($daftarLowongan as $lowongan)
                        <option value="{{ $lowongan->id }}" {{ old('lowongan_id', $lamaran->lowongan_id) == $lowongan->id ? 'selected' : '' }}>
                            {{ $lowongan->posisi }} - {{ $lowongan->perusahaan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Surat Pengantar *</label>
                <textarea name="deskripsi_lamaran" class="form-control" rows="6" required>{{ old('deskripsi_lamaran', $lamaran->deskripsi_lamaran) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Upload CV Baru (opsional)</label>
                @if($lamaran->cv_file)
                    <p class="text-muted mb-1"><i class="fas fa-file"></i> CV saat ini: <a href="{{ route('jobfinder.lamaran.download-cv', $lamaran) }}">Unduh</a></p>
                @endif
                <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx">
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                <a href="{{ route('jobfinder.lamaran.index') }}" class="btn btn-outline">Batal</a>
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
            Swal.fire('Berhasil!', res.message || 'Lamaran diperbarui!', 'success').then(() => {
                window.location.href = '{{ route("jobfinder.lamaran.index") }}';
            });
        },
        error: function(xhr) {
            var msg = xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).flat().join('\n') : 'Terjadi kesalahan';
            Swal.fire('Gagal!', msg, 'error');
        }
    });
});
</script>
@endpush
