<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BiodataController extends Controller // nama kelas kontroller harus
//sama dengan nama file
{
    public function index() // nama fungsi yang tampil secara default
    {
        $biodatas = Biodata::all(); // memanggil data dari Model
        return Inertia::render('Biodata/Index', ['biodatas' => $biodatas]); //
        //memanggil views
    }
    public function create() // nama fungsi create
    {
        return Inertia::render('Biodata/Create'); //memanggil views
    }
    public function store(Request $request) //fungsi untuk requst
    //pengiriman ke DB
    {
        $request->validate([ // sesuaikan nama kolom yang mau diisi
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);
        Biodata::create($request->all()); // menghubugnkan ke Models
        return redirect()->route('biodata.index'); //memanggil views
    }
    public function edit($id) // fungsi edit dengan pengambilan data dari
    //Models
    {
        $biodata = Biodata::findOrFail($id); // mencari by Ide dari Model
        return Inertia::render('Biodata/Edit', ['biodata' => $biodata]); //
        //meanggil view
    }
    public function update(Request $request, $id) //fungsi untuk Update DB
    //dengan menghubungkan ke Models
    {
        $biodata = Biodata::findOrFail($id);
        $biodata->update($request->all()); // update data ke database
        //dengan bantuan Model
        return redirect()->route('biodata.index');
    }
    public function destroy($id) // Fungsi Hapus by Id dari DB
    {
        Biodata::destroy($id);
        return redirect()->route('biodata.index'); // Jika sukses akan
        //merefresh ke index
    }
}
