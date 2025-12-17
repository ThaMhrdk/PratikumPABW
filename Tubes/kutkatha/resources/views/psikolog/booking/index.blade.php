@extends('layouts.dashboard')

@section('title', 'Daftar Booking')
@section('page-title', 'Daftar Booking')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Booking Masuk</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('psikolog.booking.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>

        @if($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pasien</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td><code>{{ $booking->booking_code }}</code></td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->schedule->date->format('d M Y') }}</td>
                            <td>{{ $booking->schedule->formatted_time }}</td>
                            <td>{{ $booking->schedule->consultation_type_name }}</td>
                            <td>{!! $booking->status_badge !!}</td>
                            <td>
                                @if($booking->payment)
                                    {!! $booking->payment->status_badge !!}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('psikolog.booking.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('psikolog.booking.confirm', $booking) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Konfirmasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($booking->status == 'confirmed' && $booking->isPaid())
                                        <a href="{{ route('psikolog.consultation.start', $booking) }}"
                                           class="btn btn-sm btn-success" title="Mulai Konsultasi">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $bookings->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5>Belum ada booking</h5>
                <p class="text-muted">Booking dari user akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>
@endsection
