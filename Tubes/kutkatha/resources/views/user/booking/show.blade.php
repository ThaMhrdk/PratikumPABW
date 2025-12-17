@extends('layouts.dashboard')

@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')

@section('sidebar')
    @include('user.partials.sidebar')
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
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Kode Booking</p>
                        <h5><code>{{ $booking->booking_code }}</code></h5>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Tanggal Booking</p>
                        <h5>{{ $booking->created_at->format('d M Y, H:i') }}</h5>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Keluhan</h6>
                <p>{{ $booking->complaint }}</p>

                @if($booking->notes)
                <h6 class="text-muted mb-3">Catatan</h6>
                <p>{{ $booking->notes }}</p>
                @endif

                @if($booking->canBeCancelled())
                <hr>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    <i class="fas fa-times me-2"></i>Batalkan Booking
                </button>
                @endif
            </div>
        </div>

        @if($booking->consultation)
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Hasil Konsultasi</h5>
            </div>
            <div class="card-body">
                @if($booking->consultation->isCompleted())
                    <div class="mb-4">
                        <h6 class="text-muted">Ringkasan</h6>
                        <p>{{ $booking->consultation->summary }}</p>
                    </div>

                    @if($booking->consultation->diagnosis)
                    <div class="mb-4">
                        <h6 class="text-muted">Diagnosis</h6>
                        <p>{{ $booking->consultation->diagnosis }}</p>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-muted">Rekomendasi</h6>
                        <p>{{ $booking->consultation->recommendation }}</p>
                    </div>

                    @if($booking->consultation->follow_up_notes)
                    <div class="mb-4">
                        <h6 class="text-muted">Catatan Tindak Lanjut</h6>
                        <p>{{ $booking->consultation->follow_up_notes }}</p>
                    </div>
                    @endif

                    @if(!$booking->consultation->feedback)
                    <hr>
                    <a href="{{ route('user.consultation.feedback', $booking->consultation) }}" class="btn btn-primary">
                        <i class="fas fa-star me-2"></i>Berikan Feedback
                    </a>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary-custom mb-3"></i>
                        <p class="text-muted">Konsultasi sedang berlangsung</p>
                        @if($booking->schedule->consultation_type == 'chat')
                        <a href="{{ route('user.consultation.chat', $booking->consultation) }}" class="btn btn-primary">
                            <i class="fas fa-comments me-2"></i>Buka Chat
                        </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Psikolog</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $booking->schedule->psikolog->user->photo_url }}" alt=""
                     class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                <h6 class="mb-0">{{ $booking->schedule->psikolog->user->name }}</h6>
                <small class="text-muted">{{ $booking->schedule->psikolog->specialization }}</small>
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
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tipe</span>
                    <span>{{ $booking->schedule->consultation_type_name }}</span>
                </div>
                @if($booking->schedule->location)
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Lokasi</span>
                    <span>{{ $booking->schedule->location }}</span>
                </div>
                @endif
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
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Metode</span>
                        <span>{{ $booking->payment->payment_method_name ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total</span>
                        <span class="fw-bold text-primary-custom">{{ $booking->payment->formatted_amount }}</span>
                    </div>

                    @if(!$booking->isPaid() && in_array($booking->status, ['pending', 'confirmed']))
                        <a href="{{ route('user.booking.payment', $booking) }}" class="btn btn-primary w-100">
                            <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </a>
                    @endif
                @else
                    <p class="text-muted">Data pembayaran tidak tersedia</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('user.booking.cancel', $booking) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Batalkan Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan booking ini?</p>
                    <div class="mb-3">
                        <label class="form-label">Alasan Pembatalan <span class="text-danger">*</span></label>
                        <textarea name="cancel_reason" class="form-control" rows="3" required
                                  placeholder="Masukkan alasan pembatalan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
