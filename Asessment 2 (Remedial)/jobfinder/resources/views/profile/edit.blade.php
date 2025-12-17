@extends('jobfinder::layouts.main')

@section('title', 'Profil Saya')

@section('content')
@php /** @var \App\Models\User $user */ @endphp
<div class="page-header">
    <h1>Profil Saya</h1>
    <p>Kelola informasi dan keamanan akun Anda</p>
</div>

<div class="profile-grid">
    <!-- Kolom Kiri -->
    <div class="profile-main">
        <!-- Card Profil -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-id-card"></i> Informasi Profil</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span style="color: #10b981; margin-left: 0.5rem; font-size: 0.875rem;">
                            <i class="fas fa-check"></i> Tersimpan
                        </span>
                    @endif
                </form>
            </div>
        </div>

        <!-- Card Password -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-lock"></i> Ubah Password</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" 
                               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                        @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" 
                               class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                        @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <span style="color: #10b981; margin-left: 0.5rem; font-size: 0.875rem;">
                            <i class="fas fa-check"></i> Diperbarui
                        </span>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="profile-side">
        <!-- Info Card -->
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 2rem;">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 style="margin: 1rem 0 0.25rem; font-size: 1.125rem;">{{ $user->name }}</h3>
                <p style="color: #64748b; font-size: 0.875rem;">{{ $user->email }}</p>
                <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
            </div>
        </div>

        <!-- Stats -->
        <div class="card">
            <div class="card-body">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <span class="stat-label">Bergabung</span>
                        <span class="stat-value">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                @if($user->role === 'admin')
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
                    <div>
                        <span class="stat-label">Lowongan Dibuat</span>
                        <span class="stat-value">{{ \Modules\JobFinder\Models\Lowongan::count() }}</span>
                    </div>
                </div>
                @else
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
                    <div>
                        <span class="stat-label">Lamaran Terkirim</span>
                        <span class="stat-value">{{ \Modules\JobFinder\Models\Lamaran::where('user_id', $user->id)->count() }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card" style="border-color: #fecaca;">
            <div class="card-header" style="background: #fef2f2;">
                <h3 style="color: #dc2626; font-size: 0.875rem;"><i class="fas fa-exclamation-triangle"></i> Zona Berbahaya</h3>
            </div>
            <div class="card-body">
                <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 1rem;">
                    Hapus akun secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <button type="button" class="btn btn-danger" onclick="showDeleteModal()" style="width: 100%;">
                    <i class="fas fa-trash-alt"></i> Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Akun -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
        <div class="modal-header" style="background: #fef2f2;">
            <h3 style="color: #dc2626;"><i class="fas fa-exclamation-triangle"></i> Hapus Akun</h3>
            <button onclick="hideDeleteModal()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom: 1rem;">Masukkan password untuk konfirmasi penghapusan akun.</p>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Password Anda">
                    @error('password', 'userDeletion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .profile-grid { display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; }
    .profile-main { display: flex; flex-direction: column; gap: 1.5rem; }
    .profile-side { display: flex; flex-direction: column; gap: 1rem; }
    .profile-avatar {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 700; color: white;
        margin: 0 auto;
    }
    .role-badge {
        display: inline-block; padding: 0.25rem 0.75rem;
        border-radius: 20px; font-size: 0.75rem; font-weight: 600;
        margin-top: 0.5rem;
    }
    .role-admin { background: #fef3c7; color: #92400e; }
    .role-pelamar { background: #dbeafe; color: #1e40af; }
    .stat-item {
        display: flex; align-items: center; gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .stat-item:last-child { border-bottom: none; }
    .stat-icon {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: white;
    }
    .stat-label { display: block; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; }
    .stat-value { display: block; font-weight: 600; color: #1e293b; }
    
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000;
    }
    .modal-box {
        background: white; border-radius: 12px;
        width: 100%; max-width: 400px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
    }
    .modal-header h3 { margin: 0; font-size: 1rem; }
    .modal-body { padding: 1.25rem; }

    @media (max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
    }
</style>

<script>
function showDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
}
function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
@error('password', 'userDeletion')
    showDeleteModal();
@enderror
</script>
@endsection
