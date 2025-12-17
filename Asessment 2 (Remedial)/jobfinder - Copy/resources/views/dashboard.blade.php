@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-home"></i> Dashboard
    </h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-success">
            <h4 class="alert-heading">Selamat Datang, {{ Auth::user()->name }}!</h4>
            <p>Anda telah berhasil login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong>.</p>
        </div>

        <div class="row" style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
            <div class="col" style="flex: 1; min-width: 250px;">
                <div class="card text-center h-100" style="background-color: #f8f9fa;">
                    <div class="card-body">
                        <i class="fas fa-list-ul fa-3x text-primary mb-3"></i>
                        <h5>Lowongan Tersedia</h5>
                        <p class="display-4">{{ \App\Models\Lowongan::count() }}</p>
                        <a href="{{ route('lowongan.index') }}" class="btn btn-outline-primary">Lihat Lowongan</a>
                    </div>
                </div>
            </div>
            
            @if(Auth::user()->role === 'pelamar')
            <div class="col" style="flex: 1; min-width: 250px;">
                <div class="card text-center h-100" style="background-color: #f8f9fa;">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                        <h5>Lamaran Saya</h5>
                        <p class="display-4">{{ Auth::user()->lamarans()->count() }}</p>
                        <a href="{{ route('lamaran.index') }}" class="btn btn-outline-success">Lihat Lamaran</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
