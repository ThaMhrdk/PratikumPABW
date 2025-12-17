@extends('layouts.dashboard')

@section('title', 'Kelola Forum')
@section('page-title', 'Kelola Forum')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h3 class="text-primary mb-0">{{ $totalTopics }}</h3>
                <small class="text-muted">Total Topik</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h3 class="text-success mb-0">{{ $totalPosts }}</h3>
                <small class="text-muted">Total Post</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h3 class="text-warning mb-0">{{ $reportedPosts }}</h3>
                <small class="text-muted">Dilaporkan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h3 class="text-info mb-0">{{ $activeUsers }}</h3>
                <small class="text-muted">User Aktif</small>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Kelola Topik Forum</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.forum.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari topik..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Ditutup</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </form>

        @if($topics->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Topik</th>
                            <th>Pembuat</th>
                            <th>Posts</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topics as $topic)
                        <tr>
                            <td>
                                <a href="{{ route('forum.topic', $topic) }}" target="_blank">
                                    {{ Str::limit($topic->title, 50) }}
                                </a>
                            </td>
                            <td>{{ $topic->user->name }}</td>
                            <td>{{ $topic->posts_count }}</td>
                            <td>
                                @if($topic->is_closed)
                                    <span class="badge bg-secondary">Ditutup</span>
                                @elseif($topic->is_pinned)
                                    <span class="badge bg-primary">Pinned</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </td>
                            <td>{{ $topic->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('forum.topic', $topic) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                <h5>Tidak ada topik</h5>
            </div>
        @endif
    </div>
</div>
@endsection
