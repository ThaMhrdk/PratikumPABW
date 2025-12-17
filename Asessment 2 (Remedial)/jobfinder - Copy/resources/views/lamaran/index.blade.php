@extends('layouts.main')

@section('title', 'Daftar Lamaran')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-file-alt"></i> 
        @if(Auth::user()->role === 'admin')
            Semua Lamaran Masuk
        @else
            Lamaran Saya
        @endif
    </h1>
    @if(Auth::user()->role === 'pelamar')
        <a href="{{ route('lamaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Lamaran
        </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-wrapper">
            <table id="lamaranTable" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        @if(Auth::user()->role === 'admin')
                            <th>Pelamar</th>
                        @endif
                        <th>Posisi</th>
                        <th>Perusahaan</th>
                        <th>Tanggal</th>
                        <th>CV</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lamarans as $index => $lamaran)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if(Auth::user()->role === 'admin')
                                <td>
                                    <strong>{{ $lamaran->user->name }}</strong>
                                    <br><small class="text-secondary">{{ $lamaran->user->email }}</small>
                                </td>
                            @endif
                            <td>{{ $lamaran->lowongan->posisi }}</td>
                            <td>{{ $lamaran->lowongan->perusahaan }}</td>
                            <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                            <td>
                                @if($lamaran->cv_file)
                                    <a href="{{ route('lamaran.download-cv', $lamaran) }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                @else
                                    <span class="text-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('lamaran.show', $lamaran) }}" class="btn btn-sm btn-secondary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(Auth::user()->role === 'pelamar' && $lamaran->user_id === Auth::id())
                                        <a href="{{ route('lamaran.edit', $lamaran) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    @if(Auth::user()->role === 'admin')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $lamaran->id }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#lamaranTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[0, 'asc']]
    });

    // Delete handler (Admin only)
    $('.btn-delete').on('click', function() {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Hapus Lamaran?',
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
                    url: '/lamaran/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        row.fadeOut(400, function() {
                            $(this).remove();
                        });
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
