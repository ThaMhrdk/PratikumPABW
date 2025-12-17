@auth
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('jobfinder.dashboard') ? 'active' : '' }}" href="{{ route('jobfinder.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>

                @if(Auth::user()->role === 'admin')
                    {{-- Menu Admin --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lowongan.*') ? 'active' : '' }}" href="{{ route('lowongan.index') }}">
                            <i class="fas fa-clipboard-list"></i> Kelola Lowongan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lamaran.*') ? 'active' : '' }}" href="{{ route('lamaran.index') }}">
                            <i class="fas fa-file-alt"></i> Kelola Lamaran
                        </a>
                    </li>
                @else
                    {{-- Menu Pelamar --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lowongan.daftar') ? 'active' : '' }}" href="{{ route('lowongan.daftar') }}">
                            <i class="fas fa-search"></i> Cari Lowongan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lamaran.*') ? 'active' : '' }}" href="{{ route('lamaran.index') }}">
                            <i class="fas fa-file-alt"></i> Lamaran Saya
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i> Profil
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endauth

@guest
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endguest
