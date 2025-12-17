@extends('layouts.dashboard')

@section('title', 'Dashboard User')
@section('page-title', 'Dashboard')

@section('sidebar')
    <div class="nav-section">Menu Utama</div>
    <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="{{ route('user.psikolog.index') }}" class="nav-link {{ request()->routeIs('user.psikolog.*') ? 'active' : '' }}">
        <i class="fas fa-user-md"></i> Cari Psikolog
    </a>
    <a href="{{ route('user.booking.index') }}" class="nav-link {{ request()->routeIs('user.booking.*') ? 'active' : '' }}">
        <i class="fas fa-calendar-check"></i> Booking Saya
    </a>
    <a href="{{ route('user.consultation.index') }}" class="nav-link {{ request()->routeIs('user.consultation.*') ? 'active' : '' }}">
        <i class="fas fa-comments"></i> Konsultasi
    </a>

    <div class="nav-section mt-3">Komunitas</div>
    <a href="{{ route('forum.index') }}" class="nav-link {{ request()->routeIs('forum.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Forum Diskusi
    </a>
    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
        <i class="fas fa-newspaper"></i> Artikel
    </a>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Booking Aktif</h6>
                    <h2 class="mb-0">{{ $upcomingBookings->count() }}</h2>
                </div>
                <i class="fas fa-calendar-check fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Konsultasi Selesai</h6>
                    <h2 class="mb-0">{{ $completedConsultations }}</h2>
                </div>
                <i class="fas fa-check-circle fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Artikel Baru</h6>
                    <h2 class="mb-0">{{ $latestArticles->count() }}</h2>
                </div>
                <i class="fas fa-newspaper fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Booking Mendatang</h5>
                <a href="{{ route('user.booking.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($upcomingBookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Psikolog</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingBookings as $booking)
                                <tr>
                                    <td><code>{{ $booking->booking_code }}</code></td>
                                    <td>{{ $booking->schedule->psikolog->user->name }}</td>
                                    <td>{{ $booking->schedule->date->format('d M Y') }}</td>
                                    <td>{{ $booking->schedule->formatted_time }}</td>
                                    <td>{!! $booking->status_badge !!}</td>
                                    <td>
                                        <a href="{{ route('user.booking.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada booking</p>
                        <a href="{{ route('user.psikolog.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Cari Psikolog
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Artikel Terbaru</h5>
            </div>
            <div class="card-body">
                @if($latestArticles->count() > 0)
                    @foreach($latestArticles as $article)
                    <div class="d-flex mb-3 pb-3 border-bottom">
                        <img src="{{ $article->image_url }}" alt="" class="rounded me-3"
                             style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">
                                <a href="{{ route('articles.show', $article->slug) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($article->title, 40) }}
                                </a>
                            </h6>
                            <small class="text-muted">{{ $article->published_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-sm w-100">
                        Lihat Semua Artikel
                    </a>
                @else
                    <p class="text-muted text-center">Belum ada artikel</p>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body text-center">
                <i class="fas fa-headset fa-3x text-primary-custom mb-3"></i>
                <h5>Butuh Bantuan?</h5>
                <p class="text-muted small">Hubungi tim support kami jika ada pertanyaan</p>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-envelope me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
