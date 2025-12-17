@extends('layouts.dashboard')

@section('title', 'Buat Booking')
@section('page-title', 'Booking Konsultasi')

@section('sidebar')
    @include('user.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Form Booking</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                    <div class="mb-4">
                        <label class="form-label">Keluhan/Masalah yang Ingin Dikonsultasikan <span class="text-danger">*</span></label>
                        <textarea name="complaint" class="form-control @error('complaint') is-invalid @enderror"
                                  rows="5" required placeholder="Ceritakan keluhan atau masalah yang ingin Anda konsultasikan...">{{ old('complaint') }}</textarea>
                        @error('complaint')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 10 karakter</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                  rows="3" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-check me-2"></i>Buat Booking
                        </button>
                        <a href="{{ route('user.psikolog.show', $schedule->psikolog) }}" class="btn btn-outline-secondary">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Detail Booking</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ $schedule->psikolog->user->photo_url }}" alt=""
                         class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                    <h6 class="mb-0">{{ $schedule->psikolog->user->name }}</h6>
                    <small class="text-muted">{{ $schedule->psikolog->specialization }}</small>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tanggal</span>
                        <span class="fw-semibold">{{ $schedule->date->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Waktu</span>
                        <span class="fw-semibold">{{ $schedule->formatted_time }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tipe</span>
                        <span class="fw-semibold">{{ $schedule->consultation_type_name }}</span>
                    </div>
                    @if($schedule->location)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Lokasi</span>
                        <span class="fw-semibold">{{ $schedule->location }}</span>
                    </div>
                    @endif
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <span class="text-muted">Biaya</span>
                    <span class="fw-bold text-primary-custom fs-5">
                        Rp {{ number_format($schedule->psikolog->consultation_fee, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
