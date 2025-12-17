@extends('jobfinder::layouts.main')

@section('title', 'Selamat Datang - JobFinder')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 text-center">
        <div class="py-5">
            <div class="mb-4">
                <i class="fas fa-briefcase text-primary" style="font-size: 5rem;"></i>
            </div>
            <h1 class="display-4 fw-bold text-dark mb-3">Selamat Datang di JobFinder</h1>
            <p class="lead text-muted mb-4">
                Portal Lowongan Kerja Resmi Dinas Tenaga Kerja Kabupaten Bandung.
                Temukan pekerjaan impian Anda atau rekrut talenta terbaik untuk perusahaan Anda.
            </p>

            <div class="d-flex gap-3 justify-content-center mb-5">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5">
                        <i class="fas fa-user-plus me-2"></i>Daftar
                    </a>
                @else
                    <a href="{{ route('jobfinder.dashboard') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row g-4 mt-3">
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="card-body">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-3">
                    <i class="fas fa-search fa-2x text-primary"></i>
                </div>
                <h5 class="card-title">Cari Lowongan</h5>
                <p class="card-text text-muted">
                    Temukan berbagai lowongan kerja dari perusahaan-perusahaan terpercaya di Kabupaten Bandung.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="card-body">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-block mb-3">
                    <i class="fas fa-file-upload fa-2x text-success"></i>
                </div>
                <h5 class="card-title">Lamar dengan Mudah</h5>
                <p class="card-text text-muted">
                    Upload CV dan dokumen pendukung Anda dengan mudah untuk melamar pekerjaan secara online.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="card-body">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-3">
                    <i class="fas fa-chart-line fa-2x text-warning"></i>
                </div>
                <h5 class="card-title">Pantau Status</h5>
                <p class="card-text text-muted">
                    Pantau status lamaran Anda secara real-time dan dapatkan notifikasi update terbaru.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
