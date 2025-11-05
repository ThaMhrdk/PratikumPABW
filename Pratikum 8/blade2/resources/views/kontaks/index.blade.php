@extends('layouts.app')
{{-- memanggil isi konten layouts --}}

@section('title', 'Daftar Kontak')
{{-- mengisi yield title --}}

@section('content')
{{-- mengisi yield content --}}

<div class="card shadow-sm">
    <div class="card-header">
        <a href="{{ route('kontaks.create') }}" class="btn btn-primary btn-sm">
            Tambah Kontak
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
        {{-- Menampilkan pesan sukses --}}
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th width="200px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kontaks as $kontak)
                {{-- Loop data kontak --}}
                <tr>
                    <td>{{ $loop->iteration + $kontaks->firstItem() - 1 }}</td>
                    <td>{{ $kontak->nama }}</td>
                    <td>{{ $kontak->alamat }}</td>
                    <td>{{ $kontak->no_hp }}</td>
                    <td>
                        {{-- INI BAGIAN YANG DIPERBAIKI --}}
                        <form action="{{ route('kontaks.destroy', $kontak->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            
                            <a href="{{ route('kontaks.show', $kontak->id) }}" class="btn btn-info btn-sm">Lihat</a>
                            
                            <a href="{{ route('kontaks.edit', $kontak->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Data kontak kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Menampilkan link Paginasi --}}
        <div class="mt-3">
            {!! $kontaks->links() !!}
        </div>
    </div>
</div>

@endsection