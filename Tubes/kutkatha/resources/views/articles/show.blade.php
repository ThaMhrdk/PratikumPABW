@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($article->title, 50) }}</li>
                </ol>
            </nav>

            <article>
                <header class="mb-4">
                    <span class="badge bg-primary mb-3">{{ $article->category }}</span>
                    <h1 class="mb-3">{{ $article->title }}</h1>

                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $article->psikolog->user->photo_url }}" alt="" class="rounded-circle me-3"
                             style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <p class="mb-0 fw-bold">
                                {{ $article->psikolog->user->name }}
                                <span class="badge bg-success">Psikolog</span>
                            </p>
                            <small class="text-muted">
                                {{ $article->psikolog->specialization }} • {{ $article->created_at->format('d M Y') }}
                            </small>
                        </div>
                    </div>

                    @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}" alt="" class="img-fluid rounded mb-4"
                         style="width: 100%; max-height: 400px; object-fit: cover;">
                    @endif
                </header>

                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>

                @if($article->tags)
                <div class="mt-4">
                    <strong>Tags:</strong>
                    @foreach(explode(',', $article->tags) as $tag)
                    <span class="badge bg-light text-dark">{{ trim($tag) }}</span>
                    @endforeach
                </div>
                @endif

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>{{ $article->views_count }} views
                        </small>
                    </div>
                    <div>
                        <span class="text-muted me-2">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                           target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                           target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Author Box -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{ $article->psikolog->user->photo_url }}" alt="" class="rounded-circle me-3"
                             style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="mb-1">{{ $article->psikolog->user->name }}</h5>
                            <p class="text-primary-custom mb-2">{{ $article->psikolog->specialization }}</p>
                            <p class="text-muted small mb-2">{{ Str::limit($article->psikolog->bio, 150) }}</p>
                            <a href="{{ route('user.psikolog.show', $article->psikolog) }}" class="btn btn-sm btn-outline-primary">
                                Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
            <div class="mt-5">
                <h4 class="mb-4">Artikel Terkait</h4>
                <div class="row g-4">
                    @foreach($relatedArticles as $related)
                    <div class="col-md-4">
                        <div class="card h-100">
                            @if($related->featured_image)
                            <img src="{{ Storage::url($related->featured_image) }}" class="card-img-top" alt=""
                                 style="height: 120px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ route('articles.show', $related) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($related->title, 50) }}
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Artikel Populer</h5>
                </div>
                <div class="card-body">
                    @foreach($popularArticles as $popular)
                    <div class="d-flex mb-3">
                        @if($popular->featured_image)
                        <img src="{{ Storage::url($popular->featured_image) }}" alt="" class="rounded me-3"
                             style="width: 60px; height: 60px; object-fit: cover;">
                        @endif
                        <div>
                            <a href="{{ route('articles.show', $popular) }}" class="text-decoration-none text-dark">
                                <h6 class="mb-1">{{ Str::limit($popular->title, 50) }}</h6>
                            </a>
                            <small class="text-muted">{{ $popular->views_count }} views</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Butuh Konsultasi?</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Konsultasikan masalah kesehatan mental Anda dengan psikolog profesional.</p>
                    <a href="{{ route('user.psikolog.index') }}" class="btn btn-primary w-100">
                        <i class="fas fa-calendar-check me-2"></i>Booking Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.article-content p {
    margin-bottom: 1.5rem;
}
</style>
@endsection
