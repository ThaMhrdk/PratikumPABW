<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Inventaris (Sync)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- TOMBOL TAMBAH BARANG (Ada disini) --}}
                <div class="mb-6">
                    <a href="{{ route('sync.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                        + Tambah Barang Baru
                    </a>
                </div>

                {{-- PESAN SUKSES --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">No</th>
                                <th class="py-3 px-6 text-left">Nama Barang</th>
                                <th class="py-3 px-6 text-left">Kode</th>
                                <th class="py-3 px-6 text-left">Kategori</th>
                                <th class="py-3 px-6 text-left">Stok</th>
                                <th class="py-3 px-6 text-left">Harga</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($data as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6 text-left font-bold">{{ $item->nama_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $item->kode_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $item->kategori }}</td>
                                <td class="py-3 px-6 text-left">{{ $item->stok }}</td>
                                <td class="py-3 px-6 text-left">Rp {{ number_format($item->harga) }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('sync.edit', $item->id) }}" class="bg-yellow-500 text-white py-1 px-3 rounded text-xs mr-2 hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus (Menggunakan Form) --}}
                                        <form action="{{ route('sync.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded text-xs hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-3 px-6 text-center text-gray-500">
                                    Belum ada data barang. Silakan tambah data.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
