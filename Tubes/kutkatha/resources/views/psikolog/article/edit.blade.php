@extends('layouts.dashboard')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Artikel</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('psikolog.article.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $article->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Kesehatan Mental" {{ old('category', $article->category) == 'Kesehatan Mental' ? 'selected' : '' }}>Kesehatan Mental</option>
                        <option value="Parenting" {{ old('category', $article->category) == 'Parenting' ? 'selected' : '' }}>Parenting</option>
                        <option value="Hubungan" {{ old('category', $article->category) == 'Hubungan' ? 'selected' : '' }}>Hubungan</option>
                        <option value="Karir" {{ old('category', $article->category) == 'Karir' ? 'selected' : '' }}>Karir</option>
                        <option value="Pendidikan" {{ old('category', $article->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                        <option value="Tips & Trik" {{ old('category', $article->category) == 'Tips & Trik' ? 'selected' : '' }}>Tips & Trik</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Ringkasan <span class="text-danger">*</span></label>
                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
                              rows="2" required>{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Konten Artikel <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                              rows="15" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gambar Cover</label>
                    @if($article->featured_image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="" class="img-thumbnail" style="max-height: 100px;">
                    </div>
                    @endif
                    <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror"
                           accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Tags</label>
                    <input type="text" name="tags" class="form-control"
                           value="{{ old('tags', $article->tags) }}"
                           placeholder="Pisahkan dengan koma">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Artikel
                </button>
                <a href="{{ route('psikolog.article.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
