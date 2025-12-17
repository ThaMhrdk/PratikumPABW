@extends('jobfinder::layouts.main')

@section('title', 'Dashboard Pelamar - JobFinder')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard Pelamar
    </h2>
    <span class="badge bg-success fs-6">Pelamar</span>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="icon primary">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h3 id="totalLamaran">0</h3>
            <p>Lamaran Terkirim</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 id="lamaranDiterima">0</h3>
            <p>Lamaran Diterima</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="icon warning">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <h3 id="lamaranPending">0</h3>
            <p>Menunggu Review</p>
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
            <div class="col-md-4">
                <a href="{{ route('lowongan.daftar') }}" class="btn btn-primary w-100 py-3">
                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                    Cari Lowongan
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('lamaran.index') }}" class="btn btn-success w-100 py-3">
                    <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                    Lamaran Saya
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('profile.edit') }}" class="btn btn-warning w-100 py-3">
                    <i class="fas fa-user-edit fa-2x mb-2 d-block"></i>
                    Edit Profil
                </a>
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
                <p><strong>Role:</strong> <span class="badge bg-success">{{ ucfirst(Auth::user()->role) }}</span></p>
                <p><strong>Terdaftar:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Tips -->
<div class="card mt-4">
    <div class="card-body">
        <h5><i class="fas fa-lightbulb me-2 text-warning"></i>Tips Melamar Kerja</h5>
        <hr>
        <ul class="list-unstyled mb-0">
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pastikan CV Anda selalu terupdate</li>
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Tulis deskripsi lamaran yang menarik dan relevan</li>
            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Upload CV dalam format PDF untuk hasil terbaik</li>
            <li><i class="fas fa-check text-success me-2"></i>Pantau status lamaran Anda secara berkala</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Load statistics
    $.get("{{ route('lamaran.data') }}", function(data) {
        $('#totalLamaran').text(data.length);

        var diterima = data.filter(function(item) {
            return item.status === 'diterima';
        }).length;
        $('#lamaranDiterima').text(diterima);

        var pending = data.filter(function(item) {
            return item.status === 'pending';
        }).length;
        $('#lamaranPending').text(pending);
    });
});
</script>
@endpush
