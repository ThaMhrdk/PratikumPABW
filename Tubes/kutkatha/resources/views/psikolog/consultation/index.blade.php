@extends('layouts.dashboard')

@section('title', 'Daftar Konsultasi')
@section('page-title', 'Daftar Konsultasi')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Riwayat Konsultasi</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('psikolog.consultation.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>

        @if($consultations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pasien</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $consultation->booking->user->photo_url }}" alt=""
                                         class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                    {{ $consultation->booking->user->name }}
                                </div>
                            </td>
                            <td>{{ $consultation->booking->schedule->date->format('d M Y') }}</td>
                            <td>{{ $consultation->booking->schedule->consultation_type_name }}</td>
                            <td>
                                @if($consultation->isCompleted())
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning">Berlangsung</span>
                                @endif
                            </td>
                            <td>
                                @if($consultation->feedback)
                                    <i class="fas fa-star text-warning"></i> {{ $consultation->feedback->rating }}/5
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('psikolog.consultation.show', $consultation) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $consultations->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                <h5>Belum ada konsultasi</h5>
                <p class="text-muted">Riwayat konsultasi akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>
@endsection
