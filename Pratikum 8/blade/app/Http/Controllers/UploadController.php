<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Simpan file ke storage/app/public/uploads
        $path = $request->file('file')->store('uploads', 'public');

        // Simpan data file ke database
        Upload::create([
            'filename' => $request->file('file')->getClientOriginalName(),
            'filepath' => $path,
        ]);

        return back()->with('success', 'File berhasil diupload dan disimpan!');
    }
}