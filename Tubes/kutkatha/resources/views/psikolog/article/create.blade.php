@extends('layouts.dashboard')

@section('title', 'Tulis Artikel')
@section('page-title', 'Tulis Artikel Baru')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Form Artikel</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('psikolog.article.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Kesehatan Mental" {{ old('category') == 'Kesehatan Mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                        <option value="Parenting" {{ old('category') == 'Parenting' ? 'selected' : '' }}>Parenting</option>
                        <option value="Hubungan" {{ old('category') == 'Hubungan' ? 'selected' : '' }}>Hubungan</option>
                        <option value="Karir" {{ old('category') == 'Karir' ? 'selected' : '' }}>Karir</option>
                        <option value="Pendidikan" {{ old('category') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="Tips & Trik" {{ old('category') == 'Tips & Trik' ? 'selected' : '' }}>Tips & Trik</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Ringkasan <span class="text-danger">*</span></label>
                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
                              rows="2" required>{{ old('excerpt') }}</textarea>
                    <small class="text-muted">Ringkasan singkat yang akan ditampilkan di daftar artikel</small>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Konten Artikel <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                              rows="15" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gambar Cover</label>
                    <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror"
                           accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Sekarang</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags') }}"
                           placeholder="Pisahkan dengan koma: depresi, anxiety, stress">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Artikel
                </button>
                <a href="{{ route('psikolog.article.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
