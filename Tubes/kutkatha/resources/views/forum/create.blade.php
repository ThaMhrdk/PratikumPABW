@extends('layouts.app')

@section('title', 'Buat Topik Baru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
                    <li class="breadcrumb-item active">Buat Topik Baru</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Buat Topik Diskusi Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Judul Topik <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Tulis judul yang jelas dan menarik" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Kesehatan Mental" {{ old('category') == 'Kesehatan Mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                                <option value="Kecemasan" {{ old('category') == 'Kecemasan' ? 'selected' : '' }}>Kecemasan</option>
                                <option value="Depresi" {{ old('category') == 'Depresi' ? 'selected' : '' }}>Depresi</option>
                                <option value="Hubungan" {{ old('category') == 'Hubungan' ? 'selected' : '' }}>Hubungan</option>
                                <option value="Keluarga" {{ old('category') == 'Keluarga' ? 'selected' : '' }}>Keluarga</option>
                                <option value="Karir" {{ old('category') == 'Karir' ? 'selected' : '' }}>Karir</option>
                                <option value="Curhat" {{ old('category') == 'Curhat' ? 'selected' : '' }}>Curhat</option>
                                <option value="Tips & Motivasi" {{ old('category') == 'Tips & Motivasi' ? 'selected' : '' }}>Tips & Motivasi</option>
                                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="8" placeholder="Jelaskan topik diskusi Anda secara detail..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 50 karakter</small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_anonymous" class="form-check-input" id="is_anonymous"
                                       {{ old('is_anonymous') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_anonymous">
                                    Posting secara anonim (nama Anda akan ditampilkan sebagai "Anonim")
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info small">
                            <h6><i class="fas fa-info-circle me-2"></i>Panduan Forum</h6>
                            <ul class="mb-0">
                                <li>Gunakan bahasa yang sopan dan menghargai sesama</li>
                                <li>Jangan membagikan informasi pribadi sensitif</li>
                                <li>Topik yang melanggar aturan akan dihapus</li>
                                <li>Jika membutuhkan bantuan profesional segera, silakan booking konsultasi</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Posting Topik
                            </button>
                            <a href="{{ route('forum.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
