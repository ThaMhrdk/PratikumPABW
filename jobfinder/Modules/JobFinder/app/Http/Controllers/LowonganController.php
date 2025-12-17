<?php

namespace Modules\JobFinder\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\JobFinder\App\Models\Lowongan;

class LowonganController extends BaseController
{
    /**
     * Tampilkan halaman daftar lowongan (AJAX View)
     */
    public function index()
    {
        return view('jobfinder::lowongan.index');
    }

    /**
     * Ambil semua data lowongan (JSON untuk AJAX)
     */
    public function getData(): JsonResponse
    {
        $data = Lowongan::latest()->get();
        return response()->json($data);
    }

    /**
     * Simpan atau update data lowongan
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi_kerja' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji' => 'nullable|integer|min:0',
        ]);

        Lowongan::updateOrCreate(
            ['id' => $request->id],
            [
                'posisi' => $request->posisi,
                'perusahaan' => $request->perusahaan,
                'lokasi_kerja' => $request->lokasi_kerja,
                'deskripsi' => $request->deskripsi,
                'gaji' => $request->gaji,
            ]
        );

        return response()->json(['success' => 'Data lowongan berhasil disimpan!']);
    }

    /**
     * Ambil satu data untuk edit
     */
    public function edit($id): JsonResponse
    {
        $lowongan = Lowongan::findOrFail($id);
        return response()->json($lowongan);
    }

    /**
     * Hapus data lowongan
     */
    public function destroy($id): JsonResponse
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->delete();
        return response()->json(['success' => 'Data lowongan berhasil dihapus!']);
    }

    /**
     * Tampilkan daftar lowongan untuk pelamar
     */
    public function daftarLowongan()
    {
        $lowongan = Lowongan::latest()->get();
        return view('jobfinder::lowongan.daftar', compact('lowongan'));
    }
}
