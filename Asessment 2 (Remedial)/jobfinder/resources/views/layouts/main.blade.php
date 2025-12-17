<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobFinder') - Portal Karir Kabupaten Bandung</title>
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
</head>
<body class="jobfinder-module">
    <!-- Header Utama -->
    <header class="main-header">
        <div class="header-container">
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-building-user"></i>
                <span>JobFinder</span>
            </a>
            <p class="header-subtitle">Portal Karir Kabupaten Bandung</p>
        </div>
    </header>

    <!-- Navigasi Sederhana untuk Auth -->
    <nav class="main-nav">
        <div class="nav-container">
            <ul class="nav-menu">
                <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Beranda</a></li>
                @guest
                    <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Daftar</a></li>
                @else
                    <li><a href="{{ route('jobfinder.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="main-content">
        <div class="container">
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validasi Error --}}
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-info">
                    <p>&copy; {{ date('Y') }} JobFinder Bandung</p>
                    <p>Dinas Tenaga Kerja Kabupaten Bandung</p>
                </div>
                <div class="footer-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        // Auto sembunyikan alert setelah 5 detik
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
