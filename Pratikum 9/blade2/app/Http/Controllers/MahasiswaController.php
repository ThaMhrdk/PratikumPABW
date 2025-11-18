<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller // nama kelas kontroller harus sama dengan nama file
{
    /**
     * Display a listing of the resource.
     */
    public function index() // nama fungsi yang tampil secara default
    {
        return view('mahasiswa.index'); // memanggil views
    }

    /**
     * Get data for datatable.
     */
    public function getData() // fungsi untuk pengambilan data JSON
    {
        $mahasiswas = Mahasiswa::latest()->get(); // Mengambil data dari Models secara DSC
        return response()->json(['data' => $mahasiswas]); // Hasil dibuat data JSON
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // fungsi untuk requst pengiriman ke DB
    {
        $request->validate([ // sesuaikan nama kolom yang mau diisi
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'prodi' => 'required',
        ]);

        Mahasiswa::create($request->all()); // menghubungkan ke Models
        return response()->json(['message' => 'Data berhasil disimpan']); // Respons sukses kirim data JSON
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) // fungsi edit dengan pengambilan berdasarkan ID
    {
        $mahasiswa = Mahasiswa::find($id); // Mencocokkan ID masukan dengan Model
        return response()->json($mahasiswa); // Respons JSON
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) // fungsi untuk Update DB dengan menghubungkan ke Models
    {
        $request->validate([ // sesuaikan nama kolom yang mau diedit
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $id,
            'prodi' => 'required',
        ]);

        Mahasiswa::find($id)->update($request->all()); // menghubungkan ke Models
        return response()->json(['message' => 'Data berhasil diperbarui']); // Respons JSON ketika sukses
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) // fungsi hapus dengan pengambilan data dari Models
    {
        Mahasiswa::destroy($id); // Fungsi Hapus by Id dari DB
        return response()->json(['message' => 'Data berhasil dihapus']); // Respons JSON saat Berhasil
    }
}
