<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div>
            <label for="file" class="block font-medium text-sm text-gray-700">Upload Berkas</label>
            <input type="file" name="file" id="file" class="mt-2 border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                Upload
            </button>
        </div>
    </form>

    @if(session('success'))
        <div class="mt-4 p-2 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @php
        $files = \App\Models\Upload::all();
    @endphp
    <div class="mt-6">
        <h3 class="font-semibold text-lg">Daftar File</h3>
        <ul class="list-disc ml-6 mt-2">
            @foreach($files as $file)
                <li>
                    {{ $file->filename }} -
                    <a href="{{ asset('storage/' . $file->filepath) }}" class="text-blue-600 underline" target="_blank">Lihat</a>
                </li>
            @endforeach
        </ul>
    </div>

</x-app-layout>