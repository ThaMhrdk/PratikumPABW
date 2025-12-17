@extends('layouts.app')

@section('title', 'Artikel Kesehatan Mental')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="mb-4">Artikel Kesehatan Mental</h2>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('articles.index') }}" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Cari artikel..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($featuredArticle)
            <div class="card mb-4">
                @if($featuredArticle->featured_image)
                <img src="{{ Storage::url($featuredArticle->featured_image) }}" class="card-img-top" alt=""
                     style="height: 300px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <span class="badge bg-primary mb-2">{{ $featuredArticle->category }}</span>
                    <h3 class="card-title">
                        <a href="{{ route('articles.show', $featuredArticle) }}" class="text-decoration-none text-dark">
                            {{ $featuredArticle->title }}
                        </a>
                    </h3>
                    <p class="card-text text-muted">{{ Str::limit($featuredArticle->excerpt, 200) }}</p>
                    <div class="d-flex align-items-center">
                        <img src="{{ $featuredArticle->psikolog->user->photo_url }}" alt="" class="rounded-circle me-2"
                             style="width: 32px; height: 32px; object-fit: cover;">
                        <div>
                            <small class="text-muted">
                                {{ $featuredArticle->psikolog->user->name }} • {{ $featuredArticle->created_at->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row g-4">
                @forelse($articles as $article)
                <div class="col-md-6">
                    <div class="card h-100">
                        @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" class="card-img-top" alt=""
                             style="height: 180px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                             style="height: 180px;">
                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">{{ $article->category }}</span>
                            <h5 class="card-title">
                                <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($article->title, 60) }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small">{{ Str::limit($article->excerpt, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>{{ $article->views_count }}
                                </small>
                                <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                        <h5>Belum ada artikel</h5>
                        <p class="text-muted">Artikel akan segera tersedia</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $category)
                        <a href="{{ route('articles.index', ['category' => $category]) }}"
                           class="badge bg-light text-dark text-decoration-none py-2 px-3">
                            {{ $category }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Artikel Populer</h5>
                </div>
                <div class="card-body">
                    @foreach($popularArticles as $article)
                    <div class="d-flex mb-3">
                        @if($article->featured_image)
                        <img src="{{ Storage::url($article->featured_image) }}" alt="" class="rounded me-3"
                             style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                        <div class="rounded bg-light me-3 d-flex align-items-center justify-content-center"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-newspaper text-muted"></i>
                        </div>
                        @endif
                        <div>
                            <a href="{{ route('articles.show', $article) }}" class="text-decoration-none text-dark">
                                <h6 class="mb-1">{{ Str::limit($article->title, 50) }}</h6>
                            </a>
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>{{ $article->views_count }} views
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Butuh Bantuan?</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Jika Anda membutuhkan bantuan profesional, jangan ragu untuk berkonsultasi dengan psikolog kami.</p>
                    <a href="{{ route('user.psikolog.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-user-md me-2"></i>Cari Psikolog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
