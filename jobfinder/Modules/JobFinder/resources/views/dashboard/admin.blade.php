@extends('jobfinder::layouts.main')

@section('title', 'Dashboard Admin - JobFinder')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Admin
    </h2>
    <span class="badge bg-danger fs-6">Administrator</span>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="icon primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 id="totalLowongan">0</h3>
            <p>Total Lowongan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="icon success">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3 id="totalLamaran">0</h3>
            <p>Total Lamaran</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="icon warning">
                <i class="fas fa-clock"></i>
            </div>
            <h3 id="lamaranPending">0</h3>
            <p>Lamaran Pending</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <a href="{{ route('lowongan.index') }}" class="btn btn-primary w-100 py-3">
                    <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                    Kelola Lowongan
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('lamaran.index') }}" class="btn btn-success w-100 py-3">
                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                    Kelola Lamaran
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-warning w-100 py-3">
                    <i class="fas fa-user-cog fa-2x mb-2 d-block"></i>
                    Edit Profil
                </a>
            </div>
            <div class="col-md-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 py-3">
                        <i class="fas fa-sign-out-alt fa-2x mb-2 d-block"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Info Card -->
<div class="card">
    <div class="card-body">
        <h5><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Akun</h5>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Role:</strong> <span class="badge bg-danger">{{ ucfirst(Auth::user()->role) }}</span></p>
                <p><strong>Terdaftar:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Load statistics
    $.get("{{ route('lowongan.data') }}", function(data) {
        $('#totalLowongan').text(data.length);
    });

    $.get("{{ route('lamaran.data') }}", function(data) {
        $('#totalLamaran').text(data.length);
        var pending = data.filter(function(item) {
            return item.status === 'pending';
        }).length;
        $('#lamaranPending').text(pending);
    });
});
</script>
@endpush
