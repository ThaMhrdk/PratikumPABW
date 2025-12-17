@extends('layouts.dashboard')

@section('title', 'Verifikasi Psikolog')
@section('page-title', 'Verifikasi Psikolog')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h3 class="text-warning mb-0">{{ $pendingCount }}</h3>
                <small class="text-muted">Menunggu Review</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h3 class="text-success mb-0">{{ $verifiedCount }}</h3>
                <small class="text-muted">Terverifikasi</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body text-center">
                <h3 class="text-danger mb-0">{{ $rejectedCount }}</h3>
                <small class="text-muted">Ditolak</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Psikolog</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.psikolog.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/STR..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>

        @if($psikologs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Psikolog</th>
                            <th>Spesialisasi</th>
                            <th>No. STR</th>
                            <th>Pengalaman</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($psikologs as $psikolog)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $psikolog->user->photo_url }}" alt=""
                                         class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0">{{ $psikolog->user->name }}</h6>
                                        <small class="text-muted">{{ $psikolog->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $psikolog->specialization }}</td>
                            <td><code>{{ $psikolog->str_number }}</code></td>
                            <td>{{ $psikolog->experience_years }} tahun</td>
                            <td>
                                @if($psikolog->verification_status == 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif($psikolog->verification_status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $psikolog->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.psikolog.show', $psikolog) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $psikologs->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-check fa-4x text-muted mb-3"></i>
                <h5>Tidak ada data</h5>
            </div>
        @endif
    </div>
</div>
@endsection
