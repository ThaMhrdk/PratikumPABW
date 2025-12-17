<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lowongans = Lowongan::latest()->get();
            return response()->json(['data' => $lowongans]);
        }

        return view('lowongan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi_kerja' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji' => 'nullable|integer|min:0',
        ]);

        $lowongan = Lowongan::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lowongan berhasil ditambahkan!',
                'data' => $lowongan
            ]);
        }

        return redirect()->route('lowongan.index')
            ->with('success', 'Lowongan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lowongan $lowongan)
    {
        return view('lowongan.show', compact('lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        return view('lowongan.edit', compact('lowongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'lokasi_kerja' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gaji' => 'nullable|integer|min:0',
        ]);

        $lowongan->update($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lowongan berhasil diperbarui!',
                'data' => $lowongan
            ]);
        }

        return redirect()->route('lowongan.index')
            ->with('success', 'Lowongan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
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

        return redirect()->route('lowongan.index')
            ->with('success', 'Lowongan berhasil dihapus!');
    }
}
