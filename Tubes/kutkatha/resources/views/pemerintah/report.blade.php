@extends('layouts.dashboard')

@section('title', 'Laporan Pemerintah')
@section('page-title', 'Laporan Kesehatan Mental')

@section('sidebar')
    @include('pemerintah.partials.sidebar')
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pemerintah.report') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Periode</label>
                <select name="period" class="form-select">
                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="quarterly" {{ request('period') == 'quarterly' ? 'selected' : '' }}>Triwulan</option>
                    <option value="yearly" {{ request('period') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
                <a href="{{ route('pemerintah.report.export') }}" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-2"></i>Export
                </a>
            </div>
        </form>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ringkasan Layanan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td>Total Konsultasi</td>
                        <td class="text-end fw-bold">{{ $stats['total_consultations'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Konsultasi Selesai</td>
                        <td class="text-end fw-bold text-success">{{ $stats['completed_consultations'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Rata-rata Rating</td>
                        <td class="text-end fw-bold">{{ $stats['average_rating'] ?? '-' }} / 5</td>
                    </tr>
                    <tr>
                        <td>Total Warga Terlayani</td>
                        <td class="text-end fw-bold">{{ $stats['unique_users'] ?? 0 }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Tenaga Kesehatan Mental</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td>Psikolog Terdaftar</td>
                        <td class="text-end fw-bold">{{ $stats['total_psikologs'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Psikolog Terverifikasi</td>
                        <td class="text-end fw-bold text-success">{{ $stats['verified_psikologs'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Psikolog Aktif (30 hari)</td>
                        <td class="text-end fw-bold">{{ $stats['active_psikologs'] ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Rata-rata Konsultasi/Psikolog</td>
                        <td class="text-end fw-bold">{{ $stats['avg_consultations_per_psikolog'] ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Tren Layanan</h5>
    </div>
    <div class="card-body">
        <canvas id="trendChart" height="80"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Laporan yang Dikirim Admin</h5>
    </div>
    <div class="card-body">
        @if(isset($reports) && $reports->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Periode</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->title }}</td>
                            <td><span class="badge bg-primary">{{ $report->type }}</span></td>
                            <td>{{ $report->period }}</td>
                            <td>{{ $report->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('pemerintah.report.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted text-center py-3 mb-0">Belum ada laporan</p>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('trendChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        datasets: [{
            label: 'Konsultasi',
            data: {!! json_encode($chartData ?? [65, 78, 90, 85, 99, 112]) !!},
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
