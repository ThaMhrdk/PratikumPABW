@extends('layouts.main')

@section('title', 'Buat Lamaran')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-paper-plane"></i> Buat Lamaran Pekerjaan
    </h1>
    <a href="{{ route('lamaran.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-file-alt"></i> Form Lamaran</h3>
    </div>
    <div class="card-body">
        <form id="createForm" action="{{ route('lamaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="lowongan_id" class="form-label required">Pilih Lowongan</label>
                <select name="lowongan_id" id="lowongan_id" class="form-control @error('lowongan_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Lowongan --</option>
                    @foreach($lowongans as $lowongan)
                        <option value="{{ $lowongan->id }}" 
                            {{ (old('lowongan_id') ?? request('lowongan')) == $lowongan->id ? 'selected' : '' }}>
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
                          rows="5" placeholder="Jelaskan mengapa Anda tertarik dengan posisi ini dan kualifikasi yang Anda miliki..." required>{{ old('deskripsi_lamaran') }}</textarea>
                @error('deskripsi_lamaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cv_file" class="form-label">Upload CV (Opsional)</label>
                <div class="file-input-wrapper">
                    <input type="file" name="cv_file" id="cv_file" 
                           accept=".pdf,.doc,.docx"
                           class="@error('cv_file') is-invalid @enderror">
                    <label for="cv_file" class="file-input-label" id="fileLabel">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <div>
                            <strong>Klik untuk upload atau drag & drop</strong>
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
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> Kirim Lamaran
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
        var file = this.files[0];
        
        if (file && file.size > 5 * 1024 * 1024) { // 5MB limit
            Swal.fire({
                icon: 'error',
                title: 'Ukuran File Terlalu Besar',
                text: 'Maksimal ukuran file adalah 5MB.'
            });
            $(this).val(''); // Reset input
            $('#fileName').hide();
            $('#fileLabel').css('border-color', 'var(--border-color)');
            return;
        }

        var fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $('#fileName').text('File dipilih: ' + fileName).show();
            $('#fileLabel').css('border-color', 'var(--success)');
        } else {
            $('#fileName').hide();
            $('#fileLabel').css('border-color', 'var(--border-color)');
        }
    });

    // AJAX form submission
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var formData = new FormData(this);
        
        // Show loading
        Swal.fire({
            title: 'Mengirim Lamaran...',
            text: 'Mohon tunggu sebentar',
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message || 'Lamaran berhasil dikirim!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = '{{ route("lamaran.index") }}';
                });
            },
            error: function(xhr) {
                console.log('Error:', xhr);
                var errors = xhr.responseJSON?.errors;
                if (errors) {
                    var errorMsg = Object.values(errors).flat().join('\n');
                    Swal.fire('Error!', errorMsg, 'error');
                } else if (xhr.responseJSON?.message) {
                    Swal.fire('Error!', xhr.responseJSON.message, 'error');
                } else {
                    Swal.fire('Error!', 'Gagal mengirim lamaran. Status: ' + xhr.status, 'error');
                }
            }
        });
    });
});
</script>
@endpush

