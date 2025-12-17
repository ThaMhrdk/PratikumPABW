@extends('layouts.main')

@section('title', 'Register')

@section('content')
<div class="d-flex justify-center align-center" style="min-height: 60vh;">
    <div class="card" style="max-width: 500px; width: 100%;">
        <div class="card-header">
            <h3><i class="fas fa-user-plus"></i> Daftar Akun Baru</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required autofocus autocomplete="name"
                           placeholder="Masukkan nama lengkap">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required autocomplete="username"
                           placeholder="Masukkan email Anda">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label required">Password</label>
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           required autocomplete="new-password"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           required autocomplete="new-password"
                           placeholder="Ulangi password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>

                <div class="text-center mt-3">
                    <p class="text-secondary">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-primary" style="font-weight: 600;">
                            Login Sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
