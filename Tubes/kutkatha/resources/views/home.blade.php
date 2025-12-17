@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6 py-5">
                <h1 class="display-4 fw-bold mb-4">Kesehatan Mental Anda, Prioritas Kami</h1>
                <p class="lead mb-4">
                    Kutkatha menyediakan layanan konseling psikologis profesional untuk masyarakat
                    Kutai Kartanegara. Konsultasi online, offline, atau melalui chat dengan psikolog berpengalaman.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('register.role') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                    @else
                        @if(Auth::user()->isUser())
                            <a href="{{ route('user.psikolog.index') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-search me-2"></i>Cari Psikolog
                            </a>
                        @endif
                        <a href="{{ route('forum.index') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-comments me-2"></i>Forum Komunitas
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center py-5">
                <img src="https://illustrations.popsy.co/amber/remote-work.svg" alt="Mental Health" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Layanan Kami</h2>
            <p class="text-muted">Berbagai pilihan konsultasi sesuai kebutuhan Anda</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-primary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-video fa-2x text-primary-custom"></i>
                        </div>
                        <h5 class="card-title">Konsultasi Online</h5>
                        <p class="card-text text-muted">
                            Konsultasi melalui video call dari rumah Anda. Praktis dan nyaman tanpa perlu keluar rumah.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-secondary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-hospital fa-2x text-success"></i>
                        </div>
                        <h5 class="card-title">Konsultasi Tatap Muka</h5>
                        <p class="card-text text-muted">
                            Bertemu langsung dengan psikolog di lokasi yang telah ditentukan untuk konsultasi mendalam.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4">
                    <div class="card-body">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-comments fa-2x text-warning"></i>
                        </div>
                        <h5 class="card-title">Chat Konseling</h5>
                        <p class="card-text text-muted">
                            Curhat melalui chat dengan psikolog. Cocok untuk Anda yang lebih nyaman berkomunikasi via teks.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cara Kerja</h2>
            <p class="text-muted">Langkah mudah untuk memulai konsultasi</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <div class="rounded-circle bg-primary-custom text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold fs-4">1</span>
                </div>
                <h5>Daftar Akun</h5>
                <p class="text-muted small">Buat akun gratis untuk mengakses layanan</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="rounded-circle bg-primary-custom text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold fs-4">2</span>
                </div>
                <h5>Pilih Psikolog</h5>
                <p class="text-muted small">Cari psikolog sesuai kebutuhan Anda</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="rounded-circle bg-primary-custom text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold fs-4">3</span>
                </div>
                <h5>Booking Jadwal</h5>
                <p class="text-muted small">Pilih jadwal dan tipe konsultasi</p>
            </div>
            <div class="col-md-3 text-center">
                <div class="rounded-circle bg-primary-custom text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <span class="fw-bold fs-4">4</span>
                </div>
                <h5>Mulai Konsultasi</h5>
                <p class="text-muted small">Lakukan konsultasi dengan psikolog</p>
            </div>
        </div>
    </div>
</section>

<!-- Psychologists -->
@if($psikologs->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Psikolog Kami</h2>
                <p class="text-muted mb-0">Psikolog profesional siap membantu Anda</p>
            </div>
            @auth
                @if(Auth::user()->isUser())
                <a href="{{ route('user.psikolog.index') }}" class="btn btn-outline-primary">
                    Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
                </a>
                @endif
            @endauth
        </div>
        <div class="row g-4">
            @foreach($psikologs as $psikolog)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <img src="{{ $psikolog->user->photo_url }}" alt="{{ $psikolog->user->name }}"
                             class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="card-title mb-1">{{ $psikolog->user->name }}</h5>
                        <p class="text-primary-custom mb-2">{{ $psikolog->specialization }}</p>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-briefcase me-1"></i>{{ $psikolog->experience_years }} tahun pengalaman
                        </p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-star text-warning me-1"></i>{{ $psikolog->average_rating }}
                            </span>
                            <span class="badge bg-light text-dark">
                                {{ $psikolog->total_consultations }} konsultasi
                            </span>
                        </div>
                        @auth
                            @if(Auth::user()->isUser())
                            <a href="{{ route('user.psikolog.show', $psikolog) }}" class="btn btn-primary btn-sm">
                                Lihat Profil
                            </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                Lihat Profil
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Articles -->
@if($articles->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Artikel Kesehatan Mental</h2>
                <p class="text-muted mb-0">Tingkatkan pemahaman Anda tentang kesehatan mental</p>
            </div>
            <a href="{{ route('articles.index') }}" class="btn btn-outline-primary">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($articles as $article)
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="{{ $article->image_url }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <span class="badge bg-primary-custom mb-2">{{ $article->category }}</span>
                        <h5 class="card-title">{{ Str::limit($article->title, 50) }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $article->published_at?->format('d M Y') ?? $article->created_at->format('d M Y') }}
                            </small>
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-sm btn-outline-primary">
                                Baca <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-primary-custom text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Butuh Bantuan?</h2>
        <p class="lead mb-4">Jangan ragu untuk berkonsultasi. Kesehatan mental sama pentingnya dengan kesehatan fisik.</p>
        @guest
            <a href="{{ route('register.role') }}" class="btn btn-light btn-lg px-5">
                Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
            </a>
        @else
            @if(Auth::user()->isUser())
            <a href="{{ route('user.psikolog.index') }}" class="btn btn-light btn-lg px-5">
                Cari Psikolog <i class="fas fa-arrow-right ms-2"></i>
            </a>
            @endif
        @endguest
    </div>
</section>
@endsection
