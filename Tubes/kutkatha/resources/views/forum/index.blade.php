@extends('layouts.app')

@section('title', 'Forum Diskusi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Forum Diskusi</h2>
                @auth
                <a href="{{ route('forum.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Buat Topik Baru
                </a>
                @endauth
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('forum.index') }}" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Cari topik..."
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

            @if($pinnedTopics->count() > 0)
            <div class="mb-4">
                <h5 class="text-muted mb-3"><i class="fas fa-thumbtack me-2"></i>Topik Terpin</h5>
                @foreach($pinnedTopics as $topic)
                <div class="card mb-2 border-primary">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-primary me-2">Pinned</span>
                                <a href="{{ route('forum.topic', $topic) }}" class="text-decoration-none fw-bold">
                                    {{ $topic->title }}
                                </a>
                            </div>
                            <small class="text-muted">{{ $topic->posts_count }} balasan</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Topik Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    @if($topics->count() > 0)
                        @foreach($topics as $topic)
                        <div class="p-3 border-bottom {{ $topic->is_closed ? 'bg-light' : '' }}">
                            <div class="d-flex">
                                <img src="{{ $topic->user->photo_url }}" alt="" class="rounded-circle me-3"
                                     style="width: 48px; height: 48px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <a href="{{ route('forum.topic', $topic) }}" class="text-decoration-none">
                                                <h6 class="mb-1">
                                                    @if($topic->is_closed)
                                                        <i class="fas fa-lock text-muted me-1"></i>
                                                    @endif
                                                    {{ $topic->title }}
                                                </h6>
                                            </a>
                                            <small class="text-muted">
                                                oleh <strong>{{ $topic->user->name }}</strong>
                                                @if($topic->user->role == 'psikolog')
                                                    <span class="badge bg-success">Psikolog</span>
                                                @endif
                                                • {{ $topic->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <span class="badge bg-secondary">{{ $topic->category }}</span>
                                    </div>
                                    <p class="text-muted small mb-2 mt-2">{{ Str::limit($topic->description, 150) }}</p>
                                    <div class="d-flex text-muted small">
                                        <span class="me-3"><i class="fas fa-comment me-1"></i>{{ $topic->posts_count }} balasan</span>
                                        <span><i class="fas fa-eye me-1"></i>{{ $topic->views_count }} views</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="p-3">
                            {{ $topics->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                            <h5>Belum ada topik</h5>
                            <p class="text-muted">Jadilah yang pertama memulai diskusi!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tentang Forum</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Forum diskusi Kutkatha adalah tempat berbagi pengalaman,
                    bertanya, dan mendiskusikan topik seputar kesehatan mental secara anonim dan aman.</p>

                    <h6 class="mt-3">Kategori Populer</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $category)
                        <a href="{{ route('forum.index', ['category' => $category]) }}"
                           class="badge bg-light text-dark text-decoration-none">{{ $category }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistik Forum</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Topik</span>
                        <span class="fw-bold">{{ $totalTopics }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Post</span>
                        <span class="fw-bold">{{ $totalPosts }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Member Aktif</span>
                        <span class="fw-bold">{{ $activeMembers }}</span>
                    </div>
                </div>
            </div>

            @if($topContributors->count() > 0)
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Top Kontributor</h5>
                </div>
                <div class="card-body">
                    @foreach($topContributors as $contributor)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $contributor->photo_url }}" alt="" class="rounded-circle me-2"
                             style="width: 32px; height: 32px; object-fit: cover;">
                        <div>
                            <p class="mb-0 small fw-bold">{{ $contributor->name }}</p>
                            <small class="text-muted">{{ $contributor->posts_count }} posts</small>
                        </div>
                        @if($contributor->role == 'psikolog')
                            <span class="badge bg-success ms-auto">Psikolog</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
