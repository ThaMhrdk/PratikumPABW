@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total User</h6>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                </div>
                <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Psikolog Terverifikasi</h6>
                    <h2 class="mb-0">{{ $verifiedPsikologs }}</h2>
                </div>
                <i class="fas fa-user-md fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Menunggu Verifikasi</h6>
                    <h2 class="mb-0">{{ $pendingVerifications }}</h2>
                </div>
                <i class="fas fa-clock fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 opacity-75">Total Konsultasi</h6>
                    <h2 class="mb-0">{{ $totalConsultations }}</h2>
                </div>
                <i class="fas fa-comments fa-2x opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Statistik Konsultasi Bulanan</h5>
            </div>
            <div class="card-body">
                <canvas id="consultationChart" height="100"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Psikolog Menunggu Verifikasi</h5>
                <a href="{{ route('admin.psikolog.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($pendingPsikologs->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Spesialisasi</th>
                                    <th>No. STR</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingPsikologs as $psikolog)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $psikolog->user->photo_url }}" alt=""
                                                 class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                            {{ $psikolog->user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $psikolog->specialization }}</td>
                                    <td>{{ $psikolog->str_number }}</td>
                                    <td>{{ $psikolog->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.psikolog.show', $psikolog) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Review
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-3 mb-0">Tidak ada psikolog menunggu verifikasi</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Distribusi Role</h5>
            </div>
            <div class="card-body">
                <canvas id="roleChart" height="200"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.psikolog.index') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-user-check me-2"></i>Verifikasi Psikolog
                </a>
                <a href="{{ route('admin.report.index') }}" class="btn btn-outline-success w-100 mb-2">
                    <i class="fas fa-chart-bar me-2"></i>Generate Laporan
                </a>
                <a href="{{ route('admin.forum.index') }}" class="btn btn-outline-info w-100">
                    <i class="fas fa-comments me-2"></i>Kelola Forum
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Consultation Chart
new Chart(document.getElementById('consultationChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Konsultasi',
            data: {!! json_encode($chartData ?? [12, 19, 15, 25, 22, 30]) !!},
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

// Role Chart
new Chart(document.getElementById('roleChart'), {
    type: 'doughnut',
    data: {
        labels: ['User', 'Psikolog', 'Admin'],
        datasets: [{
            data: [{{ $totalUsers }}, {{ $verifiedPsikologs }}, 1],
            backgroundColor: ['#4A90A4', '#6BB5A2', '#F4A261']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
@endsection
