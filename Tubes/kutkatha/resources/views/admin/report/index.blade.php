@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total Konsultasi</h6>
                    <h2 class="mb-0">{{ $totalConsultations }}</h2>
                </div>
                <i class="fas fa-comments fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total Pendapatan</h6>
                    <h2 class="mb-0">{{ $totalRevenue }}</h2>
                </div>
                <i class="fas fa-money-bill fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Rata-rata Rating</h6>
                    <h2 class="mb-0">{{ $averageRating }}</h2>
                </div>
                <i class="fas fa-star fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">User Aktif</h6>
                    <h2 class="mb-0">{{ $activeUsers }}</h2>
                </div>
                <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Generate Laporan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.report.generate') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-3">
                <label class="form-label">Jenis Laporan</label>
                <select name="type" class="form-select" required>
                    <option value="consultations">Laporan Konsultasi</option>
                    <option value="revenue">Laporan Pendapatan</option>
                    <option value="users">Laporan User</option>
                    <option value="psikologs">Laporan Psikolog</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Periode</label>
                <select name="period" class="form-select" required>
                    <option value="daily">Harian</option>
                    <option value="weekly">Mingguan</option>
                    <option value="monthly">Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-file-export me-2"></i>Generate
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Statistik Konsultasi per Bulan</h5>
            </div>
            <div class="card-body">
                <canvas id="consultationChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Top Psikolog</h5>
            </div>
            <div class="card-body">
                @if(isset($topPsikologs) && $topPsikologs->count() > 0)
                    @foreach($topPsikologs as $i => $psikolog)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-{{ $i == 0 ? 'warning' : ($i == 1 ? 'secondary' : 'info') }} me-2">{{ $i + 1 }}</span>
                            <img src="{{ $psikolog->user->photo_url }}" alt="" class="rounded-circle me-2"
                                 style="width: 32px; height: 32px; object-fit: cover;">
                            <span>{{ $psikolog->user->name }}</span>
                        </div>
                        <small class="text-muted">{{ $psikolog->consultations_count }} sesi</small>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center mb-0">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('consultationChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Konsultasi',
            data: {!! json_encode($chartData ?? [12, 19, 15, 25, 22, 30]) !!},
            backgroundColor: '#4A90A4'
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
@endsection
