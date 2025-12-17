@extends('layouts.dashboard')

@section('title', 'Artikel Saya')
@section('page-title', 'Artikel Saya')

@section('sidebar')
    @include('psikolog.partials.sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Artikel</h5>
        <a href="{{ route('psikolog.article.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tulis Artikel
        </a>
    </div>
    <div class="card-body">
        @if($articles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td>
                                <a href="{{ route('articles.show', $article) }}" target="_blank">
                                    {{ Str::limit($article->title, 50) }}
                                </a>
                            </td>
                            <td><span class="badge bg-secondary">{{ $article->category }}</span></td>
                            <td>
                                @if($article->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>{{ $article->views_count }}</td>
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('psikolog.article.edit', $article) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('psikolog.article.destroy', $article) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $articles->links() }}
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                <h5>Belum ada artikel</h5>
                <p class="text-muted">Mulai tulis artikel untuk berbagi pengetahuan</p>
                <a href="{{ route('psikolog.article.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tulis Artikel
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
