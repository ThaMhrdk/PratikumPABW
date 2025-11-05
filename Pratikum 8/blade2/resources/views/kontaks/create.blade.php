@extends('layouts.app')
{{-- memanggil isi konten layouts --}}

@section('title', 'Tambah Kontak Baru')
{{-- mengisi yield title --}}

@section('content')
{{-- mengisi yield content --}}

<div class="card shadow-sm">
    <div class="card-body">
        
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kontaks.store') }}" method="POST">
            {{-- memanggil aksi route 'store' --}}
            @csrf
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}">
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" style="height:100px" name="alamat" id="alamat" placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan No HP" value="{{ old('no_hp') }}">
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('kontaks.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection