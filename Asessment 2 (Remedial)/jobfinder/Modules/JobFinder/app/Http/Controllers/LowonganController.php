<?php

namespace Modules\JobFinder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\JobFinder\Models\Lowongan;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar lowongan (AJAX support)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $daftarLowongan = Lowongan::latest()->get();
            return response()->json(['data' => $daftarLowongan]);
        }

        return view('jobfinder::lowongan.index');
    }

    /**
     * Form tambah lowongan baru
     */
    public function create()
    {
        return view('jobfinder::lowongan.create');
    }

    /**
     * Simpan lowongan baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi_kerja' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji' => 'nullable|integer|min:0',
        ]);

        $lowongan = Lowongan::create($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lowongan pekerjaan berhasil ditambahkan!',
                'data' => $lowongan
            ]);
        }

        return redirect()->route('jobfinder.lowongan.index')
            ->with('success', 'Lowongan pekerjaan berhasil ditambahkan!');
    }

    /**
     * Detail lowongan
     */
    public function show(Lowongan $lowongan)
    {
        return view('jobfinder::lowongan.show', compact('lowongan'));
    }

    /**
     * Form edit lowongan
     */
    public function edit(Lowongan $lowongan)
    {
        return view('jobfinder::lowongan.edit', compact('lowongan'));
    }

    /**
     * Update data lowongan
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $validatedData = $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi_kerja' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji' => 'nullable|integer|min:0',
        ]);

        $lowongan->update($validatedData);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data lowongan berhasil diperbarui!',
                'data' => $lowongan
            ]);
        }

        return redirect()->route('jobfinder.lowongan.index')
            ->with('success', 'Data lowongan berhasil diperbarui!');
    }

    /**
     * Hapus lowongan
     */
    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lowongan berhasil dihapus!'
            ]);
        }

        return redirect()->route('jobfinder.lowongan.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }
}
