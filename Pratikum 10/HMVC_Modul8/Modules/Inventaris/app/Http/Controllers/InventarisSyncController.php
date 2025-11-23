<?php

namespace Modules\Inventaris\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventaris\Models\Barang;

class InventarisSyncController extends Controller
{
    // 1. Tampilkan Halaman Utama
    public function index()
    {
        $data = Barang::latest()->get();
        return view('inventaris::sync.index', compact('data'));
    }

    // 2. Tampilkan Form Tambah
    public function create()
    {
        return view('inventaris::sync.create');
    }

    // 3. Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        Barang::create($request->all());

        return redirect()->route('sync.index')->with('success', 'Data Berhasil Ditambah!');
    }

    // 4. Tampilkan Form Edit
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('inventaris::sync.edit', compact('barang'));
    }

    // 5. Proses Update
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('sync.index')->with('success', 'Data Berhasil Diupdate!');
    }

    // 6. Proses Hapus (INI BAGIAN DELETE)
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('sync.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
