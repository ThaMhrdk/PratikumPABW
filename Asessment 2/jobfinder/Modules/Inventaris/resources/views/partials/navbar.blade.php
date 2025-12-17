<x-app-layout>
    <nav>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('JobFinder') }}
            </h2>
            <div class="container mt-5">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">JobFinder</h4>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary mb-3" onclick="tambahData()">
                            <i class="fas fa-plus"></i> Profil Admin
                        </button>
                        <button class="btn btn-primary mb-3" onclick="tambahData()">
                            <i class="fas fa-plus"></i> Tambah Lowongan
                        </button>
                        <button class="btn btn-primary mb-3" onclick="tambahData()">
                            <i class="fas fa-plus"></i> Lihat Data Pelamar
                        </button>
                    </div>
                </div>
            </div>
    </nav>
    </x-slot>
