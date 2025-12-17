@extends('jobfinder::layouts.main')

@section('title', 'Kirim Lamaran')

@section('content')
<div class="page-header">
    <h1>Kirim Lamaran</h1>
    <a href="{{ route('jobfinder.lamaran.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form id="formKirim" action="{{ route('jobfinder.lamaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Pilih Lowongan *</label>
                <select name="lowongan_id" class="form-control" required>
                    <option value="">-- Pilih Lowongan --</option>
                    @foreach($daftarLowongan as $lowongan)
                        <option value="{{ $lowongan->id }}" {{ (old('lowongan_id') ?? request('lowongan')) == $lowongan->id ? 'selected' : '' }}>
                            {{ $lowongan->posisi }} - {{ $lowongan->perusahaan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Surat Pengantar *</label>
                <textarea name="deskripsi_lamaran" class="form-control" rows="6" placeholder="Jelaskan mengapa Anda cocok untuk posisi ini..." required>{{ old('deskripsi_lamaran') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Upload CV (PDF/DOC, max 5MB)</label>
                <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx">
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Kirim Lamaran</button>
                <a href="{{ route('jobfinder.lamaran.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#formKirim').on('submit', function(e) {
    e.preventDefault();
    Swal.fire({ title: 'Mengirim...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(res) {
            Swal.fire('Berhasil!', res.message || 'Lamaran terkirim!', 'success').then(() => {
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
