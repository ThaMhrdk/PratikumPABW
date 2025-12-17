@extends('layouts.main')

@section('title', 'Edit Lamaran')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-edit"></i> Edit Lamaran
    </h1>
    <a href="{{ route('lamaran.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-file-alt"></i> Form Edit Lamaran</h3>
    </div>
    <div class="card-body">
        <form id="editForm" action="{{ route('lamaran.update', $lamaran) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="lowongan_id" class="form-label required">Pilih Lowongan</label>
                <select name="lowongan_id" id="lowongan_id" class="form-control @error('lowongan_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Lowongan --</option>
                    @foreach($lowongans as $lowongan)
                        <option value="{{ $lowongan->id }}" 
                            {{ old('lowongan_id', $lamaran->lowongan_id) == $lowongan->id ? 'selected' : '' }}>
                            {{ $lowongan->posisi }} - {{ $lowongan->perusahaan }} ({{ $lowongan->lokasi_kerja }})
                        </option>
                    @endforeach
                </select>
                @error('lowongan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi_lamaran" class="form-label required">Deskripsi Singkat</label>
                <textarea name="deskripsi_lamaran" id="deskripsi_lamaran" 
                          class="form-control @error('deskripsi_lamaran') is-invalid @enderror" 
                          rows="5" required>{{ old('deskripsi_lamaran', $lamaran->deskripsi_lamaran) }}</textarea>
                @error('deskripsi_lamaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cv_file" class="form-label">Upload CV Baru (Opsional)</label>
                @if($lamaran->cv_file)
                    <div class="alert alert-success mb-2" style="padding: 0.75rem;">
                        <i class="fas fa-file"></i> CV saat ini: 
                        <a href="{{ route('lamaran.download-cv', $lamaran) }}" class="text-success">
                            <strong>Download CV</strong>
                        </a>
                    </div>
                @endif
                <div class="file-input-wrapper">
                    <input type="file" name="cv_file" id="cv_file" 
                           accept=".pdf,.doc,.docx"
                           class="@error('cv_file') is-invalid @enderror">
                    <label for="cv_file" class="file-input-label" id="fileLabel">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div>
                            <strong>Klik untuk upload CV baru</strong>
                            <p class="text-secondary" style="margin: 0.25rem 0 0;">PDF, DOC, DOCX (Maks. 5MB)</p>
                        </div>
                    </label>
                </div>
                <div id="fileName" class="form-text text-success" style="display: none;"></div>
                @error('cv_file')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Lamaran
                </button>
                <a href="{{ route('lamaran.index') }}" class="btn btn-outline">
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
    // File input display
    $('#cv_file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $('#fileName').text('File baru dipilih: ' + fileName).show();
            $('#fileLabel').css('border-color', 'var(--success)');
        } else {
            $('#fileName').hide();
            $('#fileLabel').css('border-color', 'var(--border-color)');
        }
    });

    // Form submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = new FormData(this);

        Swal.fire({
            title: 'Menyimpan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

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
                    window.location.href = '{{ route("lamaran.index") }}';
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
