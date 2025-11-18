@extends('layouts.app') {{-- Menggunakan layout utama 'app.blade.php' --}}

@section('title', 'CRUD Mahasiswa') {{-- Menetapkan judul halaman --}}

@section('content') {{-- Bagian konten utama --}}
<div class="card">
    <div class="card-header">
        <h4>Data Mahasiswa</h4>
    </div>
    <div class="card-body">
        <button class="btn btn-primary mb-3" id="btn-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data akan diisi via AJAX --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal untuk form tambah/edit data -->
<div class="modal fade" id="modal-mahasiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-mahasiswa">
                @csrf {{-- Token keamanan Laravel, yang mana jika mengunakan AJAX harus mengunakan csrf --}}
                <div class="modal-body">
                    {{-- Input hidden untuk menyimpan ID saat edit --}}
                    <input type="hidden" id="id" name="id">

                    {{-- Input untuk nama mahasiswa --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    {{-- Input untuk NIM --}}
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>

                    {{-- Input untuk program studi --}}
                    <div class="mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <input type="text" class="form-control" id="prodi" name="prodi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- Tombol untuk menutup modal --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- Tombol untuk menyimpan data --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts') {{-- Menambahkan script JavaScript --}}
<script>
    $(document).ready(function() {
        // Fungsi yang dijalankan saat dokumen siap

        // Memuat data pertama kali saat halaman dimuat
        loadData();

        // Event ketika tombol tambah diklik
        $('#btn-tambah').click(function() {
            // Menampilkan modal
            $('#modal-mahasiswa').modal('show');
            // Mengubah judul modal
            $('#modal-title').text('Tambah Data Mahasiswa');
            // Mereset form
            $('#form-mahasiswa')[0].reset();
            // Mengosongkan ID (karena ini operasi tambah)
            $('#id').val("");
        });

        // Event ketika form disubmit (baik untuk tambah maupun edit)
        $('#form-mahasiswa').submit(function(e) {
            e.preventDefault(); // Mencegah form submit biasa

            // Mendapatkan nilai ID (akan kosong untuk operasi tambah)
            let id = $('#id').val();
            // Menentukan URL endpoint berdasarkan operasi (tambah/edit)
            let url = id ? '/mahasiswa/' + id : '/mahasiswa';
            // Menentukan method HTTP (POST untuk tambah, PUT untuk edit)
            let method = id ? 'PUT' : 'POST';

            // Mengirim request AJAX
            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(), // Mengambil semua data form
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token keamanan
                },
                success: function(response) {
                    // Jika sukses, tutup modal dan muat ulang data
                    $('#modal-mahasiswa').modal('hide');
                    loadData();
                    alert(response.message); // Tampilkan pesan sukses
                },
                error: function(xhr) {
                    // Jika error 419 (CSRF token tidak valid)
                    if (xhr.status === 419) {
                        alert('CSRF token mismatch. Please refresh the page.');
                    }
                    // Jika ada error validasi
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            alert(value[0]); // Tampilkan pesan error
                        });
                    }
                }
            });
        });

        // Fungsi untuk memuat data mahasiswa dari server
        function loadData() {
            $.ajax({
                url: '/mahasiswa/get-data', // Endpoint untuk mendapatkan data
                method: 'GET',
                success: function(response) {
                    let html = "";
                    // Membuat baris tabel untuk setiap data mahasiswa
                    $.each(response.data, function(index, item) {
                        html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nama}</td>
                            <td>${item.nim}</td>
                            <td>${item.prodi}</td>
                            <td>
                                <!-- Tombol edit -->
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Tombol hapus -->
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        `;
                    });
                    // Memasukkan data ke dalam tabel
                    $('#table-mahasiswa tbody').html(html);
                }
            });
        }

        // Event ketika tombol edit diklik
        $(document).on('click', '.btn-edit', function() {
            // Mendapatkan ID dari atribut data
            let id = $(this).data('id');

            // Mengambil data mahasiswa yang akan diedit
            $.ajax({
                url: '/mahasiswa/' + id + '/edit',
                method: 'GET',
                success: function(response) {
                    // Mengisi form modal dengan data yang didapat
                    $('#modal-title').text('Edit Data Mahasiswa');
                    $('#id').val(response.id);
                    $('#nama').val(response.nama);
                    $('#nim').val(response.nim);
                    $('#prodi').val(response.prodi);
                    // Menampilkan modal
                    $('#modal-mahasiswa').modal('show');
                }
            });
        });

        // Event ketika tombol hapus diklik
        $(document).on('click', '.btn-delete', function() {
            // Konfirmasi sebelum menghapus
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                let id = $(this).data('id');

                // Mengirim request hapus ke server
                $.ajax({
                    url: '/mahasiswa/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Memuat ulang data setelah berhasil hapus
                        loadData();
                        alert(response.message);
                    }
                });
            }
        });
    });
</script>
@endpush
