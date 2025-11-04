<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'TelU Well')</title>
    [cite_start]<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> [cite: 381-382]
    [cite_start]<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> [cite: 383-384]
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    [cite_start]<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4"> [cite: 389]
        <div class="container">
            <a class="navbar-brand" href="/">TelU Well</a>
            [cite_start]<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> [cite: 392-393]
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            [cite_start]</a> [cite: 403-405]
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">
                                <i class="fas fa-user me-1"></i>Profile
                            [cite_start]</a> [cite: 408-410]
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">
                                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                                [cite_start]</button> [cite: 426-428]
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            [cite_start]</a> [cite: 434-436]
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            [cite_start]</a> [cite: 438-440]
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            [cite_start]<div class="alert alert-success alert-dismissible fade show mt-3" role="alert"> [cite: 447-449]
                {{ session('success') }}
                [cite_start]<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> [cite: 451-452]
            </div>
        @endif
        @if ($errors->any())
            [cite_start]<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert"> [cite: 462-463]
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        [cite_start]<li>{{ $error }}</li> [cite: 464-465]
                    @endforeach
                </ul>
                [cite_start]<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> [cite: 468-469]
            </div>
        @endif
        
        @yield('content')
    </div>

    [cite_start]<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> [cite: 474]
    [cite_start]<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> [cite: 475]
    @stack('scripts')
</body>
</html>