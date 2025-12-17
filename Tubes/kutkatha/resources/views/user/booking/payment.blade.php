@extends('layouts.dashboard')

@section('title', 'Pembayaran')
@section('page-title', 'Pembayaran')

@section('sidebar')
    @include('user.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Form Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.booking.process-payment', $booking) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="transfer" value="transfer" required>
                                <label class="btn btn-outline-primary w-100 py-3" for="transfer">
                                    <i class="fas fa-university fa-2x mb-2 d-block"></i>
                                    Transfer Bank
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="ewallet" value="ewallet">
                                <label class="btn btn-outline-primary w-100 py-3" for="ewallet">
                                    <i class="fas fa-wallet fa-2x mb-2 d-block"></i>
                                    E-Wallet
                                </label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="payment_method" id="cash" value="cash">
                                <label class="btn btn-outline-primary w-100 py-3" for="cash">
                                    <i class="fas fa-money-bill-wave fa-2x mb-2 d-block"></i>
                                    Tunai
                                </label>
                            </div>
                        </div>
                        @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
                        <p class="mb-2">Transfer ke rekening berikut:</p>
                        <ul class="mb-0">
                            <li><strong>Bank BCA:</strong> 1234567890 a.n. Kutkatha</li>
                            <li><strong>Bank Mandiri:</strong> 0987654321 a.n. Kutkatha</li>
                            <li><strong>GoPay/OVO:</strong> 081234567890</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input type="file" name="proof_of_payment" class="form-control @error('proof_of_payment') is-invalid @enderror"
                               accept=".jpg,.jpeg,.png,.pdf" required>
                        @error('proof_of_payment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Kode Booking</span>
                    <code>{{ $booking->booking_code }}</code>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Psikolog</span>
                    <span>{{ $booking->schedule->psikolog->user->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tanggal</span>
                    <span>{{ $booking->schedule->date->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Waktu</span>
                    <span>{{ $booking->schedule->formatted_time }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Biaya Konsultasi</span>
                    <span>{{ $booking->payment->formatted_amount }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-primary-custom fs-4">{{ $booking->payment->formatted_amount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
