<?php

namespace Modules\Inventaris\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventaris\Models\Barang;

class InventarisAjaxController extends Controller
{
    // 1. Halaman Utama (Cuma memuat View kosong)
    public function index()
    {
        return view('inventaris::ajax.index');
    }

    // 2. Ambil Data (Untuk tabel - Format JSON)
    public function getData()
    {
        $data = Barang::latest()->get();
        return response()->json($data);
    }

    // 3. Simpan / Update Data (Format JSON)
    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'kategori'    => 'required',
            'stok'        => 'required',
            'harga'       => 'required',
        ]);

        // updateOrCreate: Kalau ada ID update, kalau tidak ada ID create baru
        Barang::updateOrCreate(
            ['id' => $request->id],
            [
                'nama_barang' => $request->nama_barang,
                'kode_barang' => $request->kode_barang,
                'kategori'    => $request->kategori,
                'stok'        => $request->stok,
                'harga'       => $request->harga
            ]
        );

        return response()->json(['success' => 'Data berhasil disimpan via AJAX!']);
    }

    // 4. Ambil 1 Data untuk Edit (Format JSON)
    public function edit($id)
    {
        $barang = Barang::find($id);
        return response()->json($barang);
    }

    // 5. Hapus Data (Format JSON)
    public function destroy($id)
    {
        Barang::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus via AJAX!']);
    }
}
