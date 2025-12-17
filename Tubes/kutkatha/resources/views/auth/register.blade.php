@extends('layouts.app')

@section('title', 'Daftar')

@php
    $role = request()->segment(2) ?? 'user';
    $isUser = $role === 'user';
@endphp

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="{{ $isUser ? 'col-md-6' : 'col-md-8' }}">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        @if($isUser)
                            <i class="fas fa-user fa-3x text-primary-custom mb-3"></i>
                            <h3 class="fw-bold">Daftar sebagai Pengguna</h3>
                        @else
                            <i class="fas fa-user-md fa-3x text-success mb-3"></i>
                            <h3 class="fw-bold">Daftar sebagai Psikolog</h3>
                        @endif
                        <p class="text-muted">Lengkapi data di bawah untuk membuat akun</p>
                    </div>

                    <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">

                        <div class="row g-3">
                            <!-- Basic Info -->
                            <div class="col-12">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="{{ $isUser ? 'col-12' : 'col-md-6' }}">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="{{ $isUser ? 'col-12' : 'col-md-6' }}">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="{{ $isUser ? 'col-12' : 'col-md-6' }}">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>

                            <div class="{{ $isUser ? 'col-12' : 'col-md-6' }}">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>

                            @if(!$isUser)
                                <!-- Psikolog Additional Fields -->
                                <div class="col-12">
                                    <hr class="my-3">
                                    <h5 class="mb-3"><i class="fas fa-id-card me-2"></i>Informasi Profesional</h5>
                                </div>

                                <div class="col-md-6">
                                    <label for="str_number" class="form-label">Nomor STR <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('str_number') is-invalid @enderror"
                                           id="str_number" name="str_number" value="{{ old('str_number') }}" required>
                                    @error('str_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Surat Tanda Registrasi Psikolog</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="specialization" class="form-label">Spesialisasi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('specialization') is-invalid @enderror"
                                            id="specialization" name="specialization" required>
                                        <option value="">Pilih Spesialisasi</option>
                                        <option value="Psikologi Klinis" {{ old('specialization') == 'Psikologi Klinis' ? 'selected' : '' }}>Psikologi Klinis</option>
                                        <option value="Psikologi Pendidikan" {{ old('specialization') == 'Psikologi Pendidikan' ? 'selected' : '' }}>Psikologi Pendidikan</option>
                                        <option value="Psikologi Industri & Organisasi" {{ old('specialization') == 'Psikologi Industri & Organisasi' ? 'selected' : '' }}>Psikologi Industri & Organisasi</option>
                                        <option value="Psikologi Anak & Remaja" {{ old('specialization') == 'Psikologi Anak & Remaja' ? 'selected' : '' }}>Psikologi Anak & Remaja</option>
                                        <option value="Psikologi Keluarga" {{ old('specialization') == 'Psikologi Keluarga' ? 'selected' : '' }}>Psikologi Keluarga</option>
                                        <option value="Psikologi Sosial" {{ old('specialization') == 'Psikologi Sosial' ? 'selected' : '' }}>Psikologi Sosial</option>
                                    </select>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="experience_years" class="form-label">Pengalaman (Tahun) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                                           id="experience_years" name="experience_years" value="{{ old('experience_years', 0) }}" min="0" required>
                                    @error('experience_years')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="consultation_fee" class="form-label">Biaya Konsultasi (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror"
                                           id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', 100000) }}" min="0" step="10000" required>
                                    @error('consultation_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="certificate_file" class="form-label">Upload Sertifikat/STR</label>
                                    <input type="file" class="form-control @error('certificate_file') is-invalid @enderror"
                                           id="certificate_file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                                    @error('certificate_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB</small>
                                </div>

                                <div class="col-12">
                                    <div class="alert alert-info small">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Akun psikolog akan diverifikasi oleh admin sebelum dapat menerima booking.
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Saya menyetujui <a href="#" class="text-primary-custom">Syarat & Ketentuan</a>
                                        dan <a href="#" class="text-primary-custom">Kebijakan Privasi</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn {{ $isUser ? 'btn-primary' : 'btn-success' }} w-100">
                                    <i class="fas fa-user-plus me-2"></i>Daftar
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <p class="text-center mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary-custom fw-semibold text-decoration-none">
                            Masuk di sini
                        </a>
                    </p>
                    <p class="text-center mb-0 mt-2">
                        <a href="{{ route('register.role') }}" class="text-muted text-decoration-none small">
                            <i class="fas fa-arrow-left me-1"></i>Kembali pilih peran
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
