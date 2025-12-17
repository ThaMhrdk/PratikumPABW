@extends('layouts.dashboard')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Booking</h5>
                {!! $booking->status_badge !!}
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Kode Booking</p>
                        <h5><code>{{ $booking->booking_code }}</code></h5>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Tanggal Booking</p>
                        <h5>{{ $booking->created_at->format('d M Y, H:i') }}</h5>
                    </div>
                </div>

                <h6 class="text-muted mb-2">Keluhan Pasien</h6>
                <div class="bg-light p-3 rounded mb-4">
                    {{ $booking->complaint }}
                </div>

                @if($booking->notes)
                <h6 class="text-muted mb-2">Catatan</h6>
                <p>{{ $booking->notes }}</p>
                @endif

                @if($booking->status == 'pending')
                <hr>
                <div class="d-flex gap-2">
                    <form action="{{ route('psikolog.booking.confirm', $booking) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Konfirmasi Booking
                        </button>
                    </form>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i>Tolak
                    </button>
                </div>
                @endif

                @if($booking->status == 'confirmed' && $booking->isPaid())
                <hr>
                <a href="{{ route('psikolog.consultation.start', $booking) }}" class="btn btn-primary">
                    <i class="fas fa-play me-2"></i>Mulai Konsultasi
                </a>
                @endif
            </div>
        </div>

        @if($booking->consultation && $booking->consultation->isCompleted())
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Hasil Konsultasi</h5>
            </div>
            <div class="card-body">
                <h6 class="text-muted">Ringkasan</h6>
                <p>{{ $booking->consultation->summary }}</p>

                @if($booking->consultation->diagnosis)
                <h6 class="text-muted">Diagnosis</h6>
                <p>{{ $booking->consultation->diagnosis }}</p>
                @endif

                <h6 class="text-muted">Rekomendasi</h6>
                <p>{{ $booking->consultation->recommendation }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Info Pasien</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $booking->user->photo_url }}" alt="" class="rounded-circle mb-2"
                     style="width: 80px; height: 80px; object-fit: cover;">
                <h5 class="mb-1">{{ $booking->user->name }}</h5>
                <p class="text-muted small mb-2">{{ $booking->user->email }}</p>
                @if($booking->user->phone)
                <p class="text-muted small"><i class="fas fa-phone me-1"></i>{{ $booking->user->phone }}</p>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Jadwal</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tanggal</span>
                    <span>{{ $booking->schedule->date->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Waktu</span>
                    <span>{{ $booking->schedule->formatted_time }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Tipe</span>
                    <span>{{ $booking->schedule->consultation_type_name }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Pembayaran</h5>
            </div>
            <div class="card-body">
                @if($booking->payment)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Status</span>
                    {!! $booking->payment->status_badge !!}
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Total</span>
                    <span class="fw-bold">{{ $booking->payment->formatted_amount }}</span>
                </div>
                @else
                <p class="text-muted mb-0">Data tidak tersedia</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('psikolog.booking.reject', $booking) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="cancel_reason" class="form-control" rows="3" required
                                  placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
