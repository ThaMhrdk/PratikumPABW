@extends('layouts.main')

@section('content')
    <div class="text-center mb-4">
        <img src="{{ asset('images/telkom-logo.png') }}" alt="Telkom University" width="100">
    </div>

    <div class="alert alert-success text-center" role="alert">
        Success: Data booking mahasiswa berhasil dimuat!
    </div>

    <h5 class="text-danger mb-4 text-center">Mahasiswa Sedang Booking Konseling</h5>

    @foreach($mahasiswas as $mahasiswa)
        <div class="card p-4 mb-4 shadow-sm">
            <p><strong>Nama:</strong> {{ $mahasiswa['nama'] }}</p>

            @if($mahasiswa['status'] === 'Mahasiswa')
                <p><strong>Jurusan:</strong> {{ $mahasiswa['jurusan'] }}</p>
            @elseif($mahasiswa['status'] === 'Pelajar')
                <p><strong>Sekolah:</strong> {{ $mahasiswa['sekolah'] }}</p>
            @elseif($mahasiswa['status'] === 'Pekerja')
                <p><strong>Kantor:</strong> {{ $mahasiswa['kantor'] }}</p>
            @elseif($mahasiswa['status'] === 'Pensiun')
                <p><strong>Kegiatan:</strong> Santai menikmati masa pensiun</p>
            @endif

            <p><strong>Umur:</strong> {{ $mahasiswa['umur'] }} tahun</p>
            <p><strong>Kode Booking:</strong> {{ $mahasiswa['kode_booking'] }}</p>
            <p><strong>Jam Booking:</strong> {{ $mahasiswa['jam_booking'] }}</p>

            @php
                $color = match($mahasiswa['status']) {
                    'Pelajar' => 'green',
                    'Mahasiswa' => 'blue',
                    'Pekerja' => 'purple',
                    'Pensiun' => 'red',
                    default => 'gray'
                };
            @endphp

            <p><strong>Status:</strong> <span style="color: {{ $color }};">{{ $mahasiswa['status'] }}</span></p>
            <p><strong>Konselor:</strong> {{ $mahasiswa['konselor'] }}</p>
        </div>
    @endforeach

    <div class="text-center mt-4">
        <h5 class="text-danger">Praktikum Laravel</h5>
        <p>Mahasiswa</p>
        <p class="text-muted">© 2025 Praktikum Laravel - Muhammad Anantha Mahardika Ridwan</p>
    </div>
@endsection
