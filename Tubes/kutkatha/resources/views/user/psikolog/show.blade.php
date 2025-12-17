@extends('layouts.dashboard')

@section('title', 'Profil Psikolog')
@section('page-title', 'Detail Psikolog')

@section('sidebar')
    @include('user.partials.sidebar')
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <img src="{{ $psikolog->user->photo_url }}" alt="{{ $psikolog->user->name }}"
                     class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h4>{{ $psikolog->user->name }}</h4>
                <p class="text-primary-custom mb-2">{{ $psikolog->specialization }}</p>
                <p class="text-muted small">STR: {{ $psikolog->str_number }}</p>

                <div class="d-flex justify-content-center gap-3 mb-3">
                    <div class="text-center">
                        <h5 class="mb-0">{{ $psikolog->experience_years }}</h5>
                        <small class="text-muted">Tahun</small>
                    </div>
                    <div class="text-center">
                        <h5 class="mb-0">{{ $psikolog->average_rating }}</h5>
                        <small class="text-muted">Rating</small>
                    </div>
                    <div class="text-center">
                        <h5 class="mb-0">{{ $psikolog->total_consultations }}</h5>
                        <small class="text-muted">Konsultasi</small>
                    </div>
                </div>

                <hr>

                <div class="text-start">
                    <p class="mb-2"><i class="fas fa-envelope me-2 text-muted"></i>{{ $psikolog->user->email }}</p>
                    @if($psikolog->user->phone)
                    <p class="mb-2"><i class="fas fa-phone me-2 text-muted"></i>{{ $psikolog->user->phone }}</p>
                    @endif
                </div>

                <hr>

                <div class="text-center">
                    <h5 class="text-primary-custom">
                        Rp {{ number_format($psikolog->consultation_fee, 0, ',', '.') }}
                    </h5>
                    <small class="text-muted">per sesi</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Tentang Psikolog</h5>
            </div>
            <div class="card-body">
                <p>{{ $psikolog->bio ?? 'Belum ada deskripsi.' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Jadwal Tersedia</h5>
            </div>
            <div class="card-body">
                @if($psikolog->schedules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Tipe</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($psikolog->schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->date->format('d M Y') }}</td>
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
                                    <td>{{ $schedule->location ?? '-' }}</td>
                                    <td>
                                        @if(!$schedule->isBooked())
                                            <a href="{{ route('user.booking.create', $schedule) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-calendar-plus me-1"></i>Booking
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Terisi</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada jadwal tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
