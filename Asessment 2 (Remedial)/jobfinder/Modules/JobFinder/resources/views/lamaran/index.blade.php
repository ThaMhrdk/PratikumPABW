@extends('jobfinder::layouts.main')

@section('title', 'Lamaran')

@section('content')
@php /** @var \App\Models\User $user */ $user = Auth::user(); @endphp
<div class="page-header">
    <h1>{{ $user->role === 'admin' ? 'Semua Lamaran' : 'Lamaran Saya' }}</h1>
    @if($user->role === 'pelamar')
        <a href="{{ route('jobfinder.lamaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Lamaran
        </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        @if($daftarLamaran->isEmpty())
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <p>Belum ada lamaran</p>
            </div>
        @else
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            @if($user->role === 'admin')<th>Pelamar</th>@endif
                            <th>Posisi</th>
                            <th>Perusahaan</th>
                            <th>Tanggal</th>
                            <th>CV</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarLamaran as $i => $lamaran)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                @if($user->role === 'admin')
                                    <td>
                                        <strong>{{ $lamaran->user->name }}</strong>
                                        <br><small class="text-muted">{{ $lamaran->user->email }}</small>
                                    </td>
                                @endif
                                <td>{{ $lamaran->lowongan->posisi }}</td>
                                <td>{{ $lamaran->lowongan->perusahaan }}</td>
                                <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($lamaran->cv_file)
                                        <a href="{{ route('jobfinder.lamaran.download-cv', $lamaran) }}" class="btn btn-outline btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('jobfinder.lamaran.show', $lamaran) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                                        @if($user->role === 'pelamar' && $lamaran->user_id === Auth::id())
                                            <a href="{{ route('jobfinder.lamaran.edit', $lamaran) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if($user->role === 'admin')
                                            <button class="btn btn-danger btn-sm btn-hapus" data-id="{{ $lamaran->id }}"><i class="fas fa-trash"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$('.btn-hapus').on('click', function() {
    var id = $(this).data('id'), row = $(this).closest('tr');
    Swal.fire({
        title: 'Hapus Lamaran?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/module/lamaran/' + id,
                type: 'DELETE',
                success: function() {
                    Swal.fire('Berhasil!', 'Lamaran dihapus.', 'success');
                    row.fadeOut();
                }
            });
        }
    });
});
</script>
@endpush
