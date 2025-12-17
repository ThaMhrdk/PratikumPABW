@extends('jobfinder::layouts.main')

@section('title', 'Kelola Lamaran - JobFinder')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fas fa-file-alt me-2 text-primary"></i>
        @if(Auth::user()->role === 'admin')
            Kelola Semua Lamaran
        @else
            Lamaran Saya
        @endif
    </h2>
    @if(Auth::user()->role === 'pelamar')
    <a href="{{ route('lowongan.daftar') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Lamar Pekerjaan
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tableLamaran">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        @if(Auth::user()->role === 'admin')
                        <th width="15%">Pelamar</th>
                        @endif
                        <th width="15%">Posisi</th>
                        <th width="15%">Perusahaan</th>
                        <th width="20%">Deskripsi</th>
                        <th width="10%">CV</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="{{ Auth::user()->role === 'admin' ? '8' : '7' }}" class="text-center">
                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Edit (untuk Pelamar) -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Lamaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lowongan</label>
                        <select name="lowongan_id" id="edit_lowongan_id" class="form-select" required>
                            @foreach($lowongan as $item)
                            <option value="{{ $item->id }}">{{ $item->posisi }} - {{ $item->perusahaan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Lamaran <span class="text-danger">*</span></label>
                        <textarea name="deskripsi_lamaran" id="edit_deskripsi" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload CV Baru</label>
                        <input type="file" name="cv_file" id="edit_cv" class="form-control" accept=".pdf,.doc,.docx">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti CV</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="btnUpdate">
                            <i class="fas fa-save me-2"></i>Update Lamaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status (untuk Admin) -->
@if(Auth::user()->role === 'admin')
<div class="modal fade" id="modalStatus" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Update Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formStatus">
                    <input type="hidden" name="lamaran_id" id="status_lamaran_id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Lamaran</label>
                        <select name="status" id="status_value" class="form-select" required>
                            <option value="pending">Menunggu</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="btnStatus">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
const isAdmin = {{ Auth::user()->role === 'admin' ? 'true' : 'false' }};

$(document).ready(function() {
    loadData();
});

// Load Data
function loadData() {
    $.get("{{ route('lamaran.data') }}", function(data) {
        let rows = '';
        let colspan = isAdmin ? 8 : 7;

        if (data.length === 0) {
            rows = `<tr><td colspan="${colspan}" class="text-center text-muted">Belum ada data lamaran</td></tr>`;
        } else {
            $.each(data, function(i, item) {
                let statusBadge = '';
                switch(item.status) {
                    case 'pending':
                        statusBadge = '<span class="badge bg-warning">Menunggu</span>';
                        break;
                    case 'diterima':
                        statusBadge = '<span class="badge bg-success">Diterima</span>';
                        break;
                    case 'ditolak':
                        statusBadge = '<span class="badge bg-danger">Ditolak</span>';
                        break;
                }

                let cvLink = item.cv_file
                    ? `<a href="{{ url('lamaran/download-cv') }}/${item.id}" class="btn btn-sm btn-outline-primary" target="_blank"><i class="fas fa-download me-1"></i>Download</a>`
                    : '<span class="text-muted">-</span>';

                rows += `<tr>
                    <td>${i + 1}</td>`;

                if (isAdmin) {
                    rows += `<td><strong>${item.user?.name || '-'}</strong><br><small class="text-muted">${item.user?.email || '-'}</small></td>`;
                }

                rows += `
                    <td>${item.lowongan?.posisi || '-'}</td>
                    <td>${item.lowongan?.perusahaan || '-'}</td>
                    <td><small>${item.deskripsi_lamaran.substring(0, 50)}${item.deskripsi_lamaran.length > 50 ? '...' : ''}</small></td>
                    <td>${cvLink}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="btn-group btn-group-sm">`;

                if (isAdmin) {
                    rows += `<button class="btn btn-info" onclick="updateStatus(${item.id}, '${item.status}')" title="Update Status"><i class="fas fa-check-circle"></i></button>`;
                    rows += `<button class="btn btn-danger" onclick="hapusData(${item.id})" title="Hapus"><i class="fas fa-trash"></i></button>`;
                } else {
                    if (item.status === 'pending') {
                        rows += `<button class="btn btn-warning" onclick="editData(${item.id})" title="Edit"><i class="fas fa-edit"></i></button>`;
                    }
                    rows += `<button class="btn btn-danger" onclick="hapusData(${item.id})" title="Hapus"><i class="fas fa-trash"></i></button>`;
                }

                rows += `</div></td></tr>`;
            });
        }
        $('#tableLamaran tbody').html(rows);
    });
}

// Edit Data (Pelamar)
function editData(id) {
    $.get("{{ url('lamaran/edit') }}/" + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_lowongan_id').val(data.lowongan_id);
        $('#edit_deskripsi').val(data.deskripsi_lamaran);
        $('#modalEdit').modal('show');
    });
}

// Submit Edit Form
$('#formEdit').submit(function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    $('#btnUpdate').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled', true);

    $.ajax({
        url: "{{ route('lamaran.store') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#modalEdit').modal('hide');
            loadData();
            alert(response.success);
            $('#btnUpdate').html('<i class="fas fa-save me-2"></i>Update Lamaran').prop('disabled', false);
        },
        error: function(xhr) {
            alert('Gagal: ' + (xhr.responseJSON?.error || 'Terjadi kesalahan'));
            $('#btnUpdate').html('<i class="fas fa-save me-2"></i>Update Lamaran').prop('disabled', false);
        }
    });
});

// Update Status (Admin)
@if(Auth::user()->role === 'admin')
function updateStatus(id, currentStatus) {
    $('#status_lamaran_id').val(id);
    $('#status_value').val(currentStatus);
    $('#modalStatus').modal('show');
}

$('#formStatus').submit(function(e) {
    e.preventDefault();

    let id = $('#status_lamaran_id').val();
    let status = $('#status_value').val();

    $('#btnStatus').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled', true);

    $.post("{{ url('lamaran/status') }}/" + id, { status: status }, function(response) {
        $('#modalStatus').modal('hide');
        loadData();
        alert(response.success);
        $('#btnStatus').html('<i class="fas fa-save me-2"></i>Update Status').prop('disabled', false);
    }).fail(function(xhr) {
        alert('Gagal: ' + (xhr.responseJSON?.error || 'Terjadi kesalahan'));
        $('#btnStatus').html('<i class="fas fa-save me-2"></i>Update Status').prop('disabled', false);
    });
});
@endif

// Hapus Data
function hapusData(id) {
    if (confirm('Yakin ingin menghapus lamaran ini?')) {
        $.ajax({
            url: "{{ url('lamaran/delete') }}/" + id,
            type: 'DELETE',
            success: function(response) {
                loadData();
                alert(response.success);
            },
            error: function(xhr) {
                alert('Gagal: ' + (xhr.responseJSON?.error || 'Terjadi kesalahan'));
            }
        });
    }
}
</script>
@endpush
