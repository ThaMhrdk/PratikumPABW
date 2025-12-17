@extends('layouts.main')

@section('title', 'Profile')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-user-circle"></i> Profile Saya
    </h1>
    <a href="{{ route('dashboard') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="d-grid gap-3" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
    <!-- Profile Information Card -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user"></i> Informasi Profile</h3>
        </div>
        <div class="card-body">
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Profile berhasil diperbarui!
                </div>
            @endif

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name" class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Role</label>
                    <div style="padding: 0.75rem 1rem; background: var(--bg-primary); border-radius: var(--border-radius-sm);">
                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-pelamar' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Terdaftar Sejak</label>
                    <div style="padding: 0.75rem 1rem; background: var(--bg-primary); border-radius: var(--border-radius-sm);">
                        {{ $user->created_at->format('d F Y, H:i') }} WIB
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- Update Password Card -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-lock"></i> Ubah Password</h3>
        </div>
        <div class="card-body">
            @if (session('status') === 'password-updated')
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Password berhasil diperbarui!
                </div>
            @endif

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="current_password" class="form-label required">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                           autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label required">Password Baru</label>
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                           autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label required">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                           autocomplete="new-password">
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key"></i> Ubah Password
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Statistics Card -->
<div class="card mt-3">
    <div class="card-header">
        <h3><i class="fas fa-chart-bar"></i> Statistik Akun</h3>
    </div>
    <div class="card-body">
        <div class="stats-grid">
            @if($user->role === 'admin')
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ \App\Models\Lowongan::count() }}</h3>
                        <p>Total Lowongan</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ \App\Models\Lamaran::count() }}</h3>
                        <p>Total Lamaran</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ \App\Models\User::where('role', 'pelamar')->count() }}</h3>
                        <p>Total Pelamar</p>
                    </div>
                </div>
            @else
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ \App\Models\Lowongan::count() }}</h3>
                        <p>Lowongan Tersedia</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $user->lamarans()->count() }}</h3>
                        <p>Lamaran Terkirim</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Account Card -->
<div class="card mt-3" style="border-color: var(--danger);">
    <div class="card-header" style="background: linear-gradient(135deg, var(--danger) 0%, #c0392b 100%);">
        <h3><i class="fas fa-exclamation-triangle"></i> Zona Berbahaya</h3>
    </div>
    <div class="card-body">
        <p class="text-secondary mb-3">
            Setelah akun dihapus, semua data dan lamaran Anda akan dihapus secara permanen. 
            Pastikan Anda telah mengunduh data yang ingin disimpan sebelum menghapus akun.
        </p>
        
        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
            <i class="fas fa-trash"></i> Hapus Akun
        </button>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-header">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Konfirmasi Hapus Akun</h3>
            <button type="button" class="modal-close" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="modal-body">
                <p class="mb-3">Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.</p>
                
                <div class="form-group">
                    <label for="delete_password" class="form-label required">Masukkan Password untuk Konfirmasi</label>
                    <input type="password" name="password" id="delete_password" 
                           class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                           placeholder="Masukkan password Anda" required>
                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

// Show modal if there are deletion errors
@if($errors->userDeletion->isNotEmpty())
    document.getElementById('deleteModal').classList.add('active');
@endif
</script>
@endpush
