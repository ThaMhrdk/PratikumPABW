<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-semibold mb-4">Upload Berkas</h3>
            <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="file" class="block font-medium text-sm text-gray-700">Pilih Berkas</label>
                    <input type="file" name="file" id="file" class="mt-2 border-gray-300 rounded-md shadow-sm w-full">
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Upload
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-semibold mb-4">Daftar File</h3>
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama File</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(App\Models\Upload::all() as $file)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ $file->filename }}
                                <a href="{{ asset('storage/' . $file->filepath) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if(auth()->user()->isAdmin() || $file->user_id === auth()->id())
                                    <form action="{{ route('upload.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus file ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 italic">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada file diupload.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <h3 class="text-lg font-semibold mb-4">Daftar User</h3>
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(App\Models\User::all() as $user)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Hapus User
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 italic">Akun Anda</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                             <tr>
                                <td colspan="3" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada user lain.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
         @if(session('error'))
            <div class="mt-4 p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>
</x-app-layout>
