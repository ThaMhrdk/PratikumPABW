<nav class="navbar">
    <div class="nav-container">
        <div class="nav-menu">
            @auth
                <a href="{{ route('jobfinder.dashboard') }}" class="nav-link {{ request()->routeIs('jobfinder.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </a>
                
                <a href="{{ route('jobfinder.lowongan.index') }}" class="nav-link {{ request()->routeIs('jobfinder.lowongan.*') ? 'active' : '' }}">
                    <i class="fas fa-list-ul"></i>
                    <span>Lowongan</span>
                </a>
                
                <a href="{{ route('jobfinder.lamaran.index') }}" class="nav-link {{ request()->routeIs('jobfinder.lamaran.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Lamaran</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
            @endauth
        </div>
        
        <div class="nav-user">
            @auth
                @php /** @var \App\Models\User $authUser */ $authUser = Auth::user(); @endphp
                <div class="user-info">
                    <span class="user-name">{{ $authUser->name }}</span>
                    <span class="user-role badge {{ $authUser->role === 'admin' ? 'badge-admin' : 'badge-pelamar' }}">
                        {{ ucfirst($authUser->role) }}
                    </span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-link logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </a>
                <a href="{{ route('register') }}" class="nav-link btn-register">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar</span>
                </a>
            @endauth
        </div>
    </div>
</nav>
