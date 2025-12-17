@extends('layouts.app')

@section('title', 'Pilih Peran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Daftar Sebagai</h2>
                <p class="text-muted">Pilih peran yang sesuai dengan Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <a href="{{ route('register', 'user') }}" class="text-decoration-none">
                        <div class="card h-100 border-2 hover-shadow">
                            <div class="card-body text-center p-5">
                                <div class="rounded-circle bg-primary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-3x text-primary-custom"></i>
                                </div>
                                <h4 class="text-dark">Pengguna</h4>
                                <p class="text-muted mb-4">
                                    Daftar sebagai pengguna untuk mengakses layanan konsultasi psikologis,
                                    forum komunitas, dan konten edukasi.
                                </p>
                                <ul class="list-unstyled text-start text-muted small">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Booking konsultasi dengan psikolog</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Akses forum komunitas</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Baca artikel kesehatan mental</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Dapat memberikan feedback</li>
                                </ul>
                                <div class="mt-4">
                                    <span class="btn btn-primary">
                                        Daftar sebagai Pengguna <i class="fas fa-arrow-right ms-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('register', 'psikolog') }}" class="text-decoration-none">
                        <div class="card h-100 border-2 hover-shadow">
                            <div class="card-body text-center p-5">
                                <div class="rounded-circle bg-secondary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                    <i class="fas fa-user-md fa-3x text-success"></i>
                                </div>
                                <h4 class="text-dark">Psikolog</h4>
                                <p class="text-muted mb-4">
                                    Daftar sebagai psikolog untuk memberikan layanan konsultasi dan
                                    membantu masyarakat Kutai Kartanegara.
                                </p>
                                <ul class="list-unstyled text-start text-muted small">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Kelola jadwal konsultasi</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Terima booking dari user</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Upload artikel edukasi</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Jawab pertanyaan di forum</li>
                                </ul>
                                <div class="mt-4">
                                    <span class="btn btn-success">
                                        Daftar sebagai Psikolog <i class="fas fa-arrow-right ms-2"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <p class="text-center mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-primary-custom fw-semibold text-decoration-none">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
</style>
@endsection
