@extends('layouts.dashboard')

@section('title', 'Dashboard Pemerintah')
@section('page-title', 'Dashboard Pemerintah')

@section('sidebar')
    @include('pemerintah.partials.sidebar')
@endsection

@section('content')
<div class="alert alert-info mb-4">
    <i class="fas fa-info-circle me-2"></i>
    Selamat datang di Dashboard Pemantauan Kesehatan Mental Kabupaten Kutai Kartanegara
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total Layanan</h6>
                    <h2 class="mb-0">{{ $totalConsultations }}</h2>
                </div>
                <i class="fas fa-handshake fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Psikolog Aktif</h6>
                    <h2 class="mb-0">{{ $activePsikologs }}</h2>
                </div>
                <i class="fas fa-user-md fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Warga Terlayani</h6>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                </div>
                <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Tingkat Kepuasan</h6>
                    <h2 class="mb-0">{{ $satisfactionRate }}%</h2>
                </div>
                <i class="fas fa-smile fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Tren Layanan Kesehatan Mental (6 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart" height="100"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Distribusi Jenis Layanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-video fa-2x text-primary mb-2"></i>
                            <h4 class="mb-0">{{ $onlineConsultations }}</h4>
                            <small class="text-muted">Konsultasi Online</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-user-friends fa-2x text-success mb-2"></i>
                            <h4 class="mb-0">{{ $offlineConsultations }}</h4>
                            <small class="text-muted">Konsultasi Offline</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-comments fa-2x text-info mb-2"></i>
                            <h4 class="mb-0">{{ $chatConsultations }}</h4>
                            <small class="text-muted">Konsultasi Chat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Distribusi Masalah</h5>
            </div>
            <div class="card-body">
                <canvas id="issueChart" height="200"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Links</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('pemerintah.reports') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan Lengkap
                </a>
                <a href="{{ route('pemerintah.statistics') }}" class="btn btn-outline-success w-100">
                    <i class="fas fa-chart-pie me-2"></i>Statistik Detail
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Trend Chart
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Jumlah Layanan',
            data: {!! json_encode($chartData ?? [65, 78, 90, 85, 99, 112]) !!},
            borderColor: '#4A90A4',
            backgroundColor: 'rgba(74, 144, 164, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

// Issue Distribution Chart
new Chart(document.getElementById('issueChart'), {
    type: 'doughnut',
    data: {
        labels: ['Kecemasan', 'Depresi', 'Stress Kerja', 'Hubungan', 'Lainnya'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: ['#4A90A4', '#6BB5A2', '#F4A261', '#E76F51', '#9CA3AF']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } }
    }
});
</script>
@endpush
@endsection
