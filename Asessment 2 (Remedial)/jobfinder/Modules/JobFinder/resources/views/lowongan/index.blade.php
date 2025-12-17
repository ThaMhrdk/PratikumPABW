@extends('jobfinder::layouts.main')

@section('title', 'Lowongan Kerja')

@section('content')
@php /** @var \App\Models\User $user */ $user = Auth::user(); @endphp
<div class="page-header">
    <h1>Lowongan Kerja</h1>
    @if($user->role === 'admin')
        <a href="{{ route('jobfinder.lowongan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah
        </a>
    @endif
</div>

<div class="job-grid" id="jobGrid">
    <!-- Loading -->
    <div class="empty-state" id="loading">
        <i class="fas fa-spinner fa-spin"></i>
        <p>Memuat data...</p>
    </div>
</div>

<div class="empty-state" id="emptyState" style="display: none;">
    <i class="fas fa-briefcase"></i>
    <p>Belum ada lowongan tersedia</p>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var isAdmin = {{ $user->role === 'admin' ? 'true' : 'false' }};
    
    $.get('{{ route("jobfinder.lowongan.index") }}', function(response) {
        $('#loading').remove();
        
        if (response.data.length === 0) {
            $('#emptyState').show();
            return;
        }
        
        var html = '';
        response.data.forEach(function(job) {
            html += '<div class="job-card">';
            html += '<h3>' + job.posisi + '</h3>';
            html += '<p class="company"><i class="fas fa-building"></i> ' + job.perusahaan + '</p>';
            html += '<div class="job-meta">';
            html += '<span><i class="fas fa-map-marker-alt"></i> ' + job.lokasi_kerja + '</span>';
            if (job.gaji) {
                html += '<span><i class="fas fa-money-bill"></i> Rp ' + new Intl.NumberFormat('id-ID').format(job.gaji) + '</span>';
            }
            html += '</div>';
            html += '<div class="actions">';
            html += '<a href="/module/lowongan/' + job.id + '" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Detail</a>';
            if (isAdmin) {
                html += '<a href="/module/lowongan/' + job.id + '/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                html += '<button class="btn btn-danger btn-sm btn-hapus" data-id="' + job.id + '"><i class="fas fa-trash"></i></button>';
            } else {
                html += '<a href="/module/lamaran/create?lowongan=' + job.id + '" class="btn btn-success btn-sm"><i class="fas fa-paper-plane"></i> Lamar</a>';
            }
            html += '</div></div>';
        });
        
        $('#jobGrid').html(html);
    });

    $(document).on('click', '.btn-hapus', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Lowongan?',
            text: 'Data tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/module/lowongan/' + id,
                    type: 'DELETE',
                    success: function() {
                        Swal.fire('Berhasil!', 'Lowongan dihapus.', 'success');
                        location.reload();
                    }
                });
            }
        });
    });
});
</script>
@endpush
