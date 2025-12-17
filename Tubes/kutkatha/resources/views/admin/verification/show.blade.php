@extends('layouts.dashboard')

@section('title', 'Detail Psikolog')
@section('page-title', 'Review Verifikasi')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Psikolog</h5>
                @if($psikolog->verification_status == 'verified')
                    <span class="badge bg-success">Terverifikasi</span>
                @elseif($psikolog->verification_status == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @else
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ $psikolog->user->photo_url }}" alt="" class="rounded-circle mb-3"
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="col-md-9">
                        <h4>{{ $psikolog->user->name }}</h4>
                        <p class="text-muted mb-2">{{ $psikolog->user->email }}</p>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Nomor STR</p>
                                <p class="fw-bold">{{ $psikolog->str_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Spesialisasi</p>
                                <p class="fw-bold">{{ $psikolog->specialization }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Pengalaman</p>
                                <p class="fw-bold">{{ $psikolog->experience_years }} tahun</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Harga Konsultasi</p>
                                <p class="fw-bold">Rp {{ number_format($psikolog->consultation_fee) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted">Biografi</h6>
                <p>{{ $psikolog->bio ?? 'Tidak ada biografi' }}</p>

                @if($psikolog->education)
                <h6 class="text-muted">Pendidikan</h6>
                <p>{{ $psikolog->education }}</p>
                @endif

                @if($psikolog->certifications)
                <h6 class="text-muted">Sertifikasi</h6>
                <p>{{ $psikolog->certifications }}</p>
                @endif
            </div>
        </div>

        @if($psikolog->verification_status == 'pending')
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Aksi Verifikasi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.psikolog.verify', $psikolog) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100"
                                    onclick="return confirm('Yakin ingin memverifikasi psikolog ini?')">
                                <i class="fas fa-check me-2"></i>Verifikasi
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times me-2"></i>Tolak
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Dokumen</h5>
            </div>
            <div class="card-body">
                @if($psikolog->str_document)
                <a href="{{ Storage::url($psikolog->str_document) }}" target="_blank" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-file-pdf me-2"></i>Lihat Dokumen STR
                </a>
                @else
                <p class="text-muted">Dokumen STR tidak tersedia</p>
                @endif

                @if($psikolog->certificate_document)
                <a href="{{ Storage::url($psikolog->certificate_document) }}" target="_blank" class="btn btn-outline-primary w-100">
                    <i class="fas fa-file-pdf me-2"></i>Lihat Sertifikat
                </a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Info Registrasi</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tanggal Daftar</span>
                    <span>{{ $psikolog->created_at->format('d M Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Telepon</span>
                    <span>{{ $psikolog->user->phone ?? '-' }}</span>
                </div>
                @if($psikolog->verified_at)
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Diverifikasi</span>
                    <span>{{ $psikolog->verified_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.psikolog.reject', $psikolog) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control" rows="4" required
                                  placeholder="Jelaskan alasan penolakan verifikasi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
