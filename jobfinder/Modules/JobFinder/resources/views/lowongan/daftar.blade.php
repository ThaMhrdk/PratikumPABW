@extends('jobfinder::layouts.main')

@section('title', 'Daftar Lowongan - JobFinder')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fas fa-search me-2 text-primary"></i>Daftar Lowongan Pekerjaan
    </h2>
    <span class="badge bg-primary fs-6">{{ count($lowongan) }} Lowongan</span>
</div>

@if(count($lowongan) == 0)
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
            <h4>Belum Ada Lowongan</h4>
            <p class="text-muted">Saat ini belum ada lowongan pekerjaan yang tersedia.</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($lowongan as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title fw-bold mb-1">{{ $item->posisi }}</h5>
                            <p class="text-muted mb-0">{{ $item->perusahaan }}</p>
                        </div>
                        <span class="badge bg-success">Aktif</span>
                    </div>

                    <div class="mb-3">
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            {{ $item->lokasi_kerja }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            {{ $item->gaji ? 'Rp ' . number_format($item->gaji, 0, ',', '.') : 'Tidak disebutkan' }}
                        </p>
                    </div>

                    @if($item->deskripsi)
                    <p class="card-text text-muted small">
                        {{ Str::limit($item->deskripsi, 100) }}
                    </p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="lamarSekarang({{ $item->id }}, '{{ $item->posisi }}', '{{ $item->perusahaan }}')">
                            <i class="fas fa-paper-plane me-2"></i>Lamar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<!-- Modal Lamar -->
<div class="modal fade" id="modalLamar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i>Form Lamaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <strong id="lamarPosisi"></strong><br>
                    <small id="lamarPerusahaan"></small>
                </div>

                <form id="formLamar" enctype="multipart/form-data">
                    <input type="hidden" name="lowongan_id" id="lowongan_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Lamaran <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_lamaran" id="deskripsi_lamaran" class="form-control" rows="4" placeholder="Tuliskan mengapa Anda cocok untuk posisi ini..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload CV <span class="text-danger">*</span></label>
                        <input type="file" name="cv_file" id="cv_file" class="form-control" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted">Format: PDF, DOC, DOCX (Maks. 2MB)</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="btnLamar">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Lamaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function lamarSekarang(id, posisi, perusahaan) {
    $('#lowongan_id').val(id);
    $('#lamarPosisi').text(posisi);
    $('#lamarPerusahaan').text(perusahaan);
    $('#formLamar')[0].reset();
    $('#modalLamar').modal('show');
}

$('#formLamar').submit(function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    $('#btnLamar').html('<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...').prop('disabled', true);

    $.ajax({
        url: "{{ route('lamaran.store') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#modalLamar').modal('hide');
            alert(response.success);
            $('#btnLamar').html('<i class="fas fa-paper-plane me-2"></i>Kirim Lamaran').prop('disabled', false);
        },
        error: function(xhr) {
            let message = 'Terjadi kesalahan';
            if (xhr.responseJSON?.error) {
                message = xhr.responseJSON.error;
            } else if (xhr.responseJSON?.errors) {
                message = Object.values(xhr.responseJSON.errors).flat().join('\n');
            }
            alert('Gagal: ' + message);
            $('#btnLamar').html('<i class="fas fa-paper-plane me-2"></i>Kirim Lamaran').prop('disabled', false);
        }
    });
});
</script>
@endpush
