<?php

namespace App\Http\Controllers;

use App\Models\Kontak; // Pastikan Model Kontak di-import
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /**
     * Menampilkan daftar semua kontak. (Fungsi READ)
     */
    public function index()
    {
        $kontaks = Kontak::latest()->paginate(5);
        return view('kontaks.index', compact('kontaks'));
    }

    /**
     * Menampilkan form untuk membuat kontak baru. (Fungsi CREATE - Form)
     */
    public function create()
    {
        return view('kontaks.create');
    }

    /**
     * Menyimpan kontak baru ke database. (Fungsi CREATE - Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        Kontak::create($request->all());

        return redirect()->route('kontaks.index')
                         ->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu kontak. (Fungsi READ - Detail)
     */
    public function show(Kontak $kontak)
    {
        return view('kontaks.show', compact('kontak'));
    }

    /**
     * Menampilkan form untuk mengedit kontak. (Fungsi UPDATE - Form)
     */
    public function edit(Kontak $kontak)
    {
        return view('kontaks.edit', compact('kontak'));
    }

    /**
     * Mengupdate data kontak di database. (Fungsi UPDATE - Store)
     */
    public function update(Request $request, Kontak $kontak)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $kontak->update($request->all());

        return redirect()->route('kontaks.index')
                         ->with('success', 'Kontak berhasil diperbarui.');
    }

    /**
     * Menghapus kontak dari database. (Fungsi DELETE)
     */
    public function destroy(Kontak $kontak)
    {
        $kontak->delete();

        return redirect()->route('kontaks.index')
                         ->with('success', 'Kontak berhasil dihapus.');
    }
}