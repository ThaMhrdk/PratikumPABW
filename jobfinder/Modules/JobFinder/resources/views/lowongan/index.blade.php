@extends('jobfinder::layouts.main')

@section('title', 'Kelola Lowongan - JobFinder')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fas fa-clipboard-list me-2 text-primary"></i>Kelola Lowongan Pekerjaan
    </h2>
    <button class="btn btn-primary" onclick="tambahData()">
        <i class="fas fa-plus me-2"></i>Tambah Lowongan
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tableLowongan">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Posisi</th>
                        <th width="20%">Perusahaan</th>
                        <th width="15%">Lokasi</th>
                        <th width="15%">Gaji</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center">
                            <i class="fas fa-spinner fa-spin"></i> Memuat data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus-circle me-2"></i>Form Lowongan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formLowongan">
                    <input type="hidden" name="id" id="id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Posisi <span class="text-danger">*</span></label>
                            <input type="text" name="posisi" id="posisi" class="form-control" placeholder="Contoh: Web Developer" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="perusahaan" id="perusahaan" class="form-control" placeholder="Contoh: PT Teknologi Bandung" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Lokasi Kerja <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi_kerja" id="lokasi_kerja" class="form-control" placeholder="Contoh: Bandung" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Gaji (Rp)</label>
                            <input type="number" name="gaji" id="gaji" class="form-control" placeholder="Contoh: 5000000" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi Pekerjaan</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi pekerjaan, kualifikasi, dll..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Lowongan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    loadData();
});

// Load Data
function loadData() {
    $.get("{{ route('lowongan.data') }}", function(data) {
        let rows = '';
        if (data.length === 0) {
            rows = '<tr><td colspan="6" class="text-center text-muted">Belum ada data lowongan</td></tr>';
        } else {
            $.each(data, function(i, item) {
                let gaji = item.gaji ? 'Rp ' + parseInt(item.gaji).toLocaleString('id-ID') : '<span class="text-muted">Tidak disebutkan</span>';
                rows += `
                <tr>
                    <td>${i + 1}</td>
                    <td><strong>${item.posisi}</strong></td>
                    <td>${item.perusahaan}</td>
                    <td><i class="fas fa-map-marker-alt text-danger me-1"></i>${item.lokasi_kerja}</td>
                    <td>${gaji}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info" onclick="lihatDetail(${item.id})" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning" onclick="editData(${item.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" onclick="hapusData(${item.id})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
            });
        }
        $('#tableLowongan tbody').html(rows);
    });
}

// Tambah Data
function tambahData() {
    $('#modalForm').modal('show');
    $('#modalTitle').html('<i class="fas fa-plus-circle me-2"></i>Tambah Lowongan Baru');
    $('#formLowongan')[0].reset();
    $('#id').val('');
}

// Simpan Data
$('#formLowongan').submit(function(e) {
    e.preventDefault();

    let formData = $(this).serialize();
    $('#btnSimpan').html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled', true);

    $.post("{{ route('lowongan.store') }}", formData, function(response) {
        $('#modalForm').modal('hide');
        loadData();
        alert(response.success);
        $('#btnSimpan').html('<i class="fas fa-save me-2"></i>Simpan Data').prop('disabled', false);
    }).fail(function(xhr) {
        alert('Gagal menyimpan data: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
        $('#btnSimpan').html('<i class="fas fa-save me-2"></i>Simpan Data').prop('disabled', false);
    });
});

// Edit Data
function editData(id) {
    $.get("{{ url('lowongan/edit') }}/" + id, function(data) {
        $('#id').val(data.id);
        $('#posisi').val(data.posisi);
        $('#perusahaan').val(data.perusahaan);
        $('#lokasi_kerja').val(data.lokasi_kerja);
        $('#deskripsi').val(data.deskripsi);
        $('#gaji').val(data.gaji);

        $('#modalTitle').html('<i class="fas fa-edit me-2"></i>Edit Lowongan');
        $('#modalForm').modal('show');
    });
}

// Lihat Detail
function lihatDetail(id) {
    $.get("{{ url('lowongan/edit') }}/" + id, function(data) {
        let gaji = data.gaji ? 'Rp ' + parseInt(data.gaji).toLocaleString('id-ID') : 'Tidak disebutkan';
        let html = `
            <div class="mb-3">
                <h6 class="text-muted mb-1">Posisi</h6>
                <p class="fs-5 fw-semibold">${data.posisi}</p>
            </div>
            <div class="mb-3">
                <h6 class="text-muted mb-1">Perusahaan</h6>
                <p>${data.perusahaan}</p>
            </div>
            <div class="mb-3">
                <h6 class="text-muted mb-1">Lokasi Kerja</h6>
                <p><i class="fas fa-map-marker-alt text-danger me-1"></i>${data.lokasi_kerja}</p>
            </div>
            <div class="mb-3">
                <h6 class="text-muted mb-1">Gaji</h6>
                <p class="fs-5 text-success">${gaji}</p>
            </div>
            <div class="mb-3">
                <h6 class="text-muted mb-1">Deskripsi</h6>
                <p>${data.deskripsi || '<span class="text-muted">Tidak ada deskripsi</span>'}</p>
            </div>
        `;
        $('#detailContent').html(html);
        $('#modalDetail').modal('show');
    });
}

// Hapus Data
function hapusData(id) {
    if (confirm('Yakin ingin menghapus lowongan ini?')) {
        $.ajax({
            url: "{{ url('lowongan/delete') }}/" + id,
            type: 'DELETE',
            success: function(response) {
                loadData();
                alert(response.success);
            },
            error: function(xhr) {
                alert('Gagal menghapus data: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    }
}
</script>
@endpush
