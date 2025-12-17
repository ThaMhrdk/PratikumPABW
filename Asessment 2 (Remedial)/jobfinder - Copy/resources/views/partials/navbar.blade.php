<nav class="navbar">
    <div class="nav-container">
        <div class="nav-menu">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('lowongan.index') }}" class="nav-link {{ request()->routeIs('lowongan.*') ? 'active' : '' }}">
                    <i class="fas fa-list-ul"></i>
                    <span>Lowongan</span>
                </a>
                
                <a href="{{ route('lamaran.index') }}" class="nav-link {{ request()->routeIs('lamaran.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Lamaran</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
            @endauth
        </div>
        
        <div class="nav-user">
            @auth
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role badge {{ Auth::user()->role === 'admin' ? 'badge-admin' : 'badge-pelamar' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="nav-link logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="nav-link btn-register">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
            @endauth
        </div>
    </div>
</nav>
