<div class="nav-section">Menu Utama</div>
<a href="{{ route('psikolog.dashboard') }}" class="nav-link {{ request()->routeIs('psikolog.dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Dashboard
</a>
<a href="{{ route('psikolog.schedule.index') }}" class="nav-link {{ request()->routeIs('psikolog.schedule.*') ? 'active' : '' }}">
    <i class="fas fa-calendar-alt"></i> Jadwal Saya
</a>
<a href="{{ route('psikolog.booking.index') }}" class="nav-link {{ request()->routeIs('psikolog.booking.*') ? 'active' : '' }}">
    <i class="fas fa-calendar-check"></i> Booking
</a>
<a href="{{ route('psikolog.consultation.index') }}" class="nav-link {{ request()->routeIs('psikolog.consultation.*') ? 'active' : '' }}">
    <i class="fas fa-comments"></i> Konsultasi
</a>

<div class="nav-section mt-3">Konten</div>
<a href="{{ route('psikolog.article.index') }}" class="nav-link {{ request()->routeIs('psikolog.article.*') ? 'active' : '' }}">
    <i class="fas fa-newspaper"></i> Artikel Saya
</a>

<div class="nav-section mt-3">Komunitas</div>
<a href="{{ route('forum.index') }}" class="nav-link {{ request()->routeIs('forum.*') ? 'active' : '' }}">
    <i class="fas fa-users"></i> Forum Diskusi
</a>
