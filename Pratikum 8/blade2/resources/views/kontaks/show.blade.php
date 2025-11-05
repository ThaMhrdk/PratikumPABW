@extends('layouts.app')

@section('title', 'Detail Kontak')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3">
            <strong>Nama:</strong>
            <p class="form-control-plaintext">{{ $kontak->nama }}</p>
        </div>
        <div class="mb-3">
            <strong>Alamat:</strong>
            <p class="form-control-plaintext">{{ $kontak->alamat }}</p>
        </div>
        <div class="mb-3">
            <strong>No HP:</strong>
            <p class="form-control-plaintext">{{ $kontak->no_hp }}</p>
        </div>
        <div class="mb-3">
            <strong>Dibuat pada:</strong>
            <p class="form-control-plaintext">{{ $kontak->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="mb-3">
            <strong>Diperbarui pada:</strong>
            <p class="form-control-plaintext">{{ $kontak->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('kontaks.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>

@endsection