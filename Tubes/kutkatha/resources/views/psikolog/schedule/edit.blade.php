@extends('layouts.dashboard')

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit Jadwal</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('psikolog.schedule.update', $schedule) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                   value="{{ old('date', $schedule->date->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                   value="{{ old('start_time', $schedule->start_time->format('H:i')) }}" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                   value="{{ old('end_time', $schedule->end_time->format('H:i')) }}" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe Konsultasi <span class="text-danger">*</span></label>
                            <select name="consultation_type" id="consultation_type"
                                    class="form-select @error('consultation_type') is-invalid @enderror" required>
                                <option value="online" {{ old('consultation_type', $schedule->consultation_type) == 'online' ? 'selected' : '' }}>Online (Video Call)</option>
                                <option value="offline" {{ old('consultation_type', $schedule->consultation_type) == 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                                <option value="chat" {{ old('consultation_type', $schedule->consultation_type) == 'chat' ? 'selected' : '' }}>Chat</option>
                            </select>
                            @error('consultation_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6" id="location_field"
                             style="{{ $schedule->consultation_type == 'offline' ? '' : 'display: none;' }}">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', $schedule->location) }}" placeholder="Alamat lokasi konsultasi">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="is_available" class="form-select">
                                <option value="1" {{ old('is_available', $schedule->is_available) ? 'selected' : '' }}>Tersedia</option>
                                <option value="0" {{ old('is_available', $schedule->is_available) ? '' : 'selected' }}>Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Jadwal
                        </button>
                        <a href="{{ route('psikolog.schedule.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('consultation_type').addEventListener('change', function() {
    const locationField = document.getElementById('location_field');
    if (this.value === 'offline') {
        locationField.style.display = 'block';
    } else {
        locationField.style.display = 'none';
    }
});
</script>
@endpush
@endsection
