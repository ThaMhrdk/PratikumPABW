@extends('layouts.dashboard')

@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Form Jadwal Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('psikolog.schedule.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                   value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
                                   value="{{ old('start_time') }}" required>
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
                                   value="{{ old('end_time') }}" required>
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tipe Konsultasi <span class="text-danger">*</span></label>
                            <select name="consultation_type" id="consultation_type"
                                    class="form-select @error('consultation_type') is-invalid @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="online" {{ old('consultation_type') == 'online' ? 'selected' : '' }}>Online (Video Call)</option>
                                <option value="offline" {{ old('consultation_type') == 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                                <option value="chat" {{ old('consultation_type') == 'chat' ? 'selected' : '' }}>Chat</option>
                            </select>
                            @error('consultation_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6" id="location_field" style="display: none;">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="Alamat lokasi konsultasi">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Jadwal
                        </button>
                        <a href="{{ route('psikolog.schedule.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info small mb-0">
                    <h6><i class="fas fa-info-circle me-2"></i>Tips</h6>
                    <ul class="mb-0">
                        <li>Pastikan jadwal tidak bertabrakan dengan jadwal lain</li>
                        <li>Untuk konsultasi offline, isi lokasi dengan jelas</li>
                        <li>Jadwal yang sudah dibooking tidak dapat diubah/dihapus</li>
                    </ul>
                </div>
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
        locationField.querySelector('input').required = true;
    } else {
        locationField.style.display = 'none';
        locationField.querySelector('input').required = false;
    }
});

// Trigger on page load
document.getElementById('consultation_type').dispatchEvent(new Event('change'));
</script>
@endpush
@endsection
