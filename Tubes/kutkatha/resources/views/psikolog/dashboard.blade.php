@extends('layouts.dashboard')

@section('title', 'Dashboard Psikolog')
@section('page-title', 'Dashboard')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
@if(!$psikolog->isVerified())
<div class="alert alert-warning mb-4">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>Status Verifikasi: {{ $psikolog->verification_status == 'pending' ? 'Menunggu Verifikasi' : 'Ditolak' }}</strong>
    <p class="mb-0 mt-2">Akun Anda sedang dalam proses verifikasi oleh admin. Anda belum dapat menerima booking sampai akun diverifikasi.</p>
</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Booking Pending</h6>
                    <h2 class="mb-0">{{ $pendingBookings }}</h2>
                </div>
                <i class="fas fa-clock fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total Konsultasi</h6>
                    <h2 class="mb-0">{{ $totalConsultations }}</h2>
                </div>
                <i class="fas fa-check-circle fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Rating</h6>
                    <h2 class="mb-0">{{ $psikolog->average_rating }}</h2>
                </div>
                <i class="fas fa-star fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Jadwal Hari Ini</h6>
                    <h2 class="mb-0">{{ $todaySchedules->count() }}</h2>
                </div>
                <i class="fas fa-calendar-day fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Jadwal Hari Ini</h5>
                <a href="{{ route('psikolog.schedule.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Jadwal
                </a>
            </div>
            <div class="card-body">
                @if($todaySchedules->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Tipe</th>
                                    <th>Pasien</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todaySchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->formatted_time }}</td>
                                    <td>
                                        @if($schedule->consultation_type == 'online')
                                            <span class="badge bg-primary">Online</span>
                                        @elseif($schedule->consultation_type == 'offline')
                                            <span class="badge bg-success">Offline</span>
                                        @else
                                            <span class="badge bg-info">Chat</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->bookings->first())
                                            {{ $schedule->bookings->first()->user->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->bookings->first())
                                            {!! $schedule->bookings->first()->status_badge !!}
                                        @else
                                            <span class="badge bg-light text-dark">Tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($schedule->bookings->first() && $schedule->bookings->first()->status == 'confirmed')
                                            <a href="{{ route('psikolog.consultation.start', $schedule->bookings->first()) }}"
                                               class="btn btn-sm btn-success">
                                                <i class="fas fa-play"></i> Mulai
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada jadwal hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Booking Mendatang</h5>
                <a href="{{ route('psikolog.booking.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($upcomingBookings->count() > 0)
                    @foreach($upcomingBookings as $booking)
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <h6 class="mb-1">{{ $booking->user->name }}</h6>
                            <small class="text-muted">
                                {{ $booking->schedule->date->format('d M Y') }} | {{ $booking->schedule->formatted_time }}
                            </small>
                        </div>
                        {!! $booking->status_badge !!}
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3 mb-0">Belum ada booking</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Profil Saya</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ Auth::user()->photo_url }}" alt="" class="rounded-circle mb-3"
                     style="width: 100px; height: 100px; object-fit: cover;">
                <h5>{{ Auth::user()->name }}</h5>
                <p class="text-primary-custom mb-2">{{ $psikolog->specialization }}</p>
                <p class="text-muted small">STR: {{ $psikolog->str_number }}</p>

                @if($psikolog->isVerified())
                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Terverifikasi</span>
                @else
                    <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Pending</span>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('psikolog.schedule.create') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-calendar-plus me-2"></i>Tambah Jadwal
                </a>
                <a href="{{ route('psikolog.article.create') }}" class="btn btn-outline-success w-100 mb-2">
                    <i class="fas fa-pen me-2"></i>Tulis Artikel
                </a>
                <a href="{{ route('forum.index') }}" class="btn btn-outline-info w-100">
                    <i class="fas fa-comments me-2"></i>Forum Diskusi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
