@extends('layouts.app')

@section('title', 'Selamat Datang - TelU Well')

@section('content')
<div class="login-container" style="max-width: 450px;">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="TelU Well Logo" style="height: 80px; width: auto; margin-bottom: 1rem; border-radius: 8px;" />
        <h2>Selamat Datang di TelU Well</h2>
    </div>

    <p style="text-align: center; margin-bottom: 2rem; color: var(--dark-gray); font-size: 1.1rem;">
        Layanan konseling untuk mahasiswa Telkom University.
    </p>

    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <a href="{{ route('login') }}" class="btn-login" style="text-decoration: none; padding: 1rem; text-align: center; display: block;">
            <i class="fas fa-sign-in-alt"></i> Klik untuk Login
        </a>
    </div>

    <div class="register-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
</div>
@endsection