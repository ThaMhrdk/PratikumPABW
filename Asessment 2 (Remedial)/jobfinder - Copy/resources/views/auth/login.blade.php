@extends('layouts.main')

@section('title', 'Login')

@section('content')
<div class="d-flex justify-center align-center" style="min-height: 60vh;">
    <div class="card" style="max-width: 450px; width: 100%;">
        <div class="card-header">
            <h3><i class="fas fa-sign-in-alt"></i> Login ke JobFinder</h3>
        </div>
        <div class="card-body">
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required autofocus autocomplete="username"
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
                           required autocomplete="current-password"
                           placeholder="Masukkan password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="remember" id="remember_me" 
                               style="width: 18px; height: 18px;">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>

                <div class="text-center mt-3">
                    <p class="text-secondary">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-primary" style="font-weight: 600;">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
