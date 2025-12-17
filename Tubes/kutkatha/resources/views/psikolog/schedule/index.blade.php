@extends('layouts.dashboard')

@section('title', 'Kelola Jadwal')
@section('page-title', 'Kelola Jadwal')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Jadwal</h5>
        <a href="{{ route('psikolog.schedule.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Jadwal
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('psikolog.schedule.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Filter tanggal">
            </div>
            <div class="col-md-4">
                <select name="type" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="online" {{ request('type') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('type') == 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="chat" {{ request('type') == 'chat' ? 'selected' : '' }}>Chat</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>

        @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Tipe</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
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
                                @if($schedule->is_available)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Tersedia</span>
                                @endif
                            </td>
                            <td>
                                @if($schedule->bookings->first())
                                    <a href="{{ route('psikolog.booking.show', $schedule->bookings->first()) }}">
                                        {{ $schedule->bookings->first()->user->name }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if(!$schedule->isBooked())
                                <div class="btn-group">
                                    <a href="{{ route('psikolog.schedule.edit', $schedule) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('psikolog.schedule.destroy', $schedule) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-muted small">Terisi</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $schedules->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5>Belum ada jadwal</h5>
                <p class="text-muted">Mulai buat jadwal konsultasi Anda</p>
                <a href="{{ route('psikolog.schedule.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Jadwal
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
