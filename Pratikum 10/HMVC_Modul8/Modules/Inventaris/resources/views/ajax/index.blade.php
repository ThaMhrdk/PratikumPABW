<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inventaris AJAX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">CRUD Asynchronous (AJAX)</h4>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
        <div class="card-body">
            <button class="btn btn-primary mb-3" onclick="tambahData()">
                <i class="fas fa-plus"></i> Tambah Barang (Ajax)
            </button>

            <table class="table table-bordered table-striped" id="tableBarang">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Form Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formBarang">
                    <input type="hidden" name="id" id="id">

                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang" id="kode_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100" id="btnSimpan">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Setup CSRF Token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        loadData(); // Panggil fungsi load saat halaman dibuka
    });

    // 1. Fungsi Load Data (Read)
    function loadData() {
        $.get("{{ route('ajax.data') }}", function(data) {
            let rows = '';
            $.each(data, function(i, item) {
                rows += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${item.nama_barang}</td>
                    <td>${item.kode_barang}</td>
                    <td>${item.kategori}</td>
                    <td>${item.stok}</td>
                    <td>Rp ${item.harga}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editData(${item.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="hapusData(${item.id})">Hapus</button>
                    </td>
                </tr>`;
            });
            $('#tableBarang tbody').html(rows);
        });
    }

    // 2. Fungsi Buka Modal Tambah
    function tambahData() {
        $('#modalForm').modal('show');
        $('#modalTitle').text('Tambah Barang');
        $('#formBarang')[0].reset(); // Kosongkan form
        $('#id').val(''); // Pastikan ID kosong
    }

    // 3. Fungsi Simpan / Update (Create/Update)
    $('#formBarang').submit(function(e) {
        e.preventDefault(); // Mencegah refresh halaman

        let formData = $(this).serialize();
        $('#btnSimpan').text('Menyimpan...');

        $.post("{{ route('ajax.store') }}", formData, function(response) {
            $('#modalForm').modal('hide');
            loadData(); // Reload tabel tanpa refresh page
            alert(response.success);
            $('#btnSimpan').text('Simpan Data');
        }).fail(function() {
            alert('Gagal menyimpan data.');
            $('#btnSimpan').text('Simpan Data');
        });
    });

    // 4. Fungsi Edit (Ambil data masuk ke Modal)
    function editData(id) {
        $.get("{{ url('inventaris-ajax/edit') }}/" + id, function(data) {
            $('#id').val(data.id);
            $('#nama_barang').val(data.nama_barang);
            $('#kode_barang').val(data.kode_barang);
            $('#kategori').val(data.kategori);
            $('#stok').val(data.stok);
            $('#harga').val(data.harga);

            $('#modalTitle').text('Edit Barang');
            $('#modalForm').modal('show');
        });
    }

    // 5. Fungsi Hapus (Delete)
    function hapusData(id) {
        if(confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: "{{ url('inventaris-ajax/delete') }}/" + id,
                type: 'DELETE',
                success: function(response) {
                    loadData(); // Reload tabel
                    alert(response.success);
                }
            });
        }
    }
</script>

</body>
</html>
