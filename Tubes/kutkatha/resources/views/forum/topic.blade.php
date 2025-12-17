@extends('layouts.app')

@section('title', $topic->title)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">Forum</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($topic->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <!-- Topic -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-secondary me-2">{{ $topic->category }}</span>
                        @if($topic->is_pinned)
                            <span class="badge bg-primary">Pinned</span>
                        @endif
                        @if($topic->is_closed)
                            <span class="badge bg-danger">Closed</span>
                        @endif
                    </div>
                    <small class="text-muted">{{ $topic->views_count }} views</small>
                </div>
                <div class="card-body">
                    <h4 class="mb-3">{{ $topic->title }}</h4>

                    <div class="d-flex mb-4">
                        <img src="{{ $topic->user->photo_url }}" alt="" class="rounded-circle me-3"
                             style="width: 48px; height: 48px; object-fit: cover;">
                        <div>
                            <p class="mb-0 fw-bold">
                                {{ $topic->user->name }}
                                @if($topic->user->role == 'psikolog')
                                    <span class="badge bg-success">Psikolog</span>
                                @endif
                            </p>
                            <small class="text-muted">{{ $topic->created_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>

                    <div class="topic-content">
                        {!! nl2br(e($topic->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Posts -->
            <h5 class="mb-3">{{ $posts->total() }} Balasan</h5>

            @foreach($posts as $post)
            <div class="card mb-3" id="post-{{ $post->id }}">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{ $post->user->photo_url }}" alt="" class="rounded-circle me-3"
                             style="width: 48px; height: 48px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-0 fw-bold">
                                        {{ $post->user->name }}
                                        @if($post->user->role == 'psikolog')
                                            <span class="badge bg-success">Psikolog</span>
                                        @endif
                                    </p>
                                    <small class="text-muted">{{ $post->created_at->format('d M Y, H:i') }}</small>
                                </div>
                                @if($post->is_best_answer)
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Jawaban Terbaik</span>
                                @endif
                            </div>

                            <div class="mt-3">
                                {!! nl2br(e($post->content)) !!}
                            </div>

                            @if($post->comments->count() > 0)
                            <div class="mt-3 ps-3 border-start">
                                @foreach($post->comments as $comment)
                                <div class="mb-2">
                                    <small>
                                        <strong>{{ $comment->user->name }}</strong>
                                        @if($comment->user->role == 'psikolog')
                                            <span class="badge bg-success badge-sm">Psikolog</span>
                                        @endif
                                        : {{ $comment->content }}
                                        <span class="text-muted">• {{ $comment->created_at->diffForHumans() }}</span>
                                    </small>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            @auth
                            <div class="mt-3">
                                <button class="btn btn-sm btn-outline-secondary"
                                        onclick="toggleCommentForm({{ $post->id }})">
                                    <i class="fas fa-reply me-1"></i>Balas
                                </button>
                            </div>

                            <div id="comment-form-{{ $post->id }}" class="mt-3" style="display: none;">
                                <form action="{{ route('forum.store-comment', $post) }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="content" class="form-control" placeholder="Tulis komentar...">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </div>
                                </form>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{ $posts->links() }}

            <!-- Reply Form -->
            @auth
            @if(!$topic->is_closed)
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Tulis Balasan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum.store-post', $topic) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                      rows="4" placeholder="Tulis balasan Anda..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Balasan
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-secondary mt-4">
                <i class="fas fa-lock me-2"></i>Topik ini sudah ditutup dan tidak menerima balasan baru.
            </div>
            @endif
            @else
            <div class="alert alert-info mt-4">
                <a href="{{ route('login') }}">Login</a> untuk ikut berdiskusi.
            </div>
            @endauth
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Info Topik</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Dibuat</span>
                        <span>{{ $topic->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Balasan</span>
                        <span>{{ $posts->total() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Views</span>
                        <span>{{ $topic->views_count }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Topik Terkait</h5>
                </div>
                <div class="card-body">
                    @if($relatedTopics->count() > 0)
                        @foreach($relatedTopics as $related)
                        <div class="mb-3">
                            <a href="{{ route('forum.topic', $related) }}" class="text-decoration-none">
                                {{ Str::limit($related->title, 50) }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $related->posts_count }} balasan</small>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Tidak ada topik terkait</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleCommentForm(postId) {
    const form = document.getElementById('comment-form-' + postId);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
@endsection
