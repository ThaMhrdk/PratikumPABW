@extends('layouts.main')

@section('title', 'Daftar Lowongan')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-briefcase"></i> Daftar Lowongan Pekerjaan
    </h1>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('lowongan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Lowongan
        </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-wrapper">
            <table id="lowonganTable" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Posisi</th>
                        <th>Perusahaan</th>
                        <th>Lokasi</th>
                        <th>Gaji</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var isAdmin = {{ Auth::user()->role === 'admin' ? 'true' : 'false' }};
    
    var table = $('#lowonganTable').DataTable({
        ajax: {
            url: '{{ route("lowongan.index") }}',
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'posisi' },
            { data: 'perusahaan' },
            { data: 'lokasi_kerja' },
            { 
                data: 'gaji',
                render: function(data) {
                    if (data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                    return '<span class="text-secondary">-</span>';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    var html = '<div class="table-actions">';
                    html += '<a href="/lowongan/' + row.id + '" class="btn btn-sm btn-secondary" title="Detail"><i class="fas fa-eye"></i></a>';
                    
                    if (isAdmin) {
                        html += '<a href="/lowongan/' + row.id + '/edit" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>';
                        html += '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' + row.id + '" title="Hapus"><i class="fas fa-trash"></i></button>';
                    } else {
                        html += '<a href="/lamaran/create?lowongan=' + row.id + '" class="btn btn-sm btn-success" title="Lamar"><i class="fas fa-paper-plane"></i></a>';
                    }
                    
                    html += '</div>';
                    return html;
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[0, 'asc']]
    });

    // Delete handler
    $('#lowonganTable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Hapus Lowongan?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#7f8c8d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/lowongan/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
