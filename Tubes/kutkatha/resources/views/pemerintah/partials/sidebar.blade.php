<div class="nav-section">Menu Utama</div>
<a href="{{ route('pemerintah.dashboard') }}" class="nav-link {{ request()->routeIs('pemerintah.dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>
<a href="{{ route('pemerintah.reports') }}" class="nav-link {{ request()->routeIs('pemerintah.reports') ? 'active' : '' }}">
    <i class="fas fa-chart-bar"></i> Laporan
</a>
<a href="{{ route('pemerintah.statistics') }}" class="nav-link {{ request()->routeIs('pemerintah.statistics') ? 'active' : '' }}">
    <i class="fas fa-chart-pie"></i> Statistik
</a>
