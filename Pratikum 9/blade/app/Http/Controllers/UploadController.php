<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Simpan file
        $path = $request->file('file')->store('uploads', 'public');

        // Simpan database
        Upload::create([
            'filename' => $request->file('file')->getClientOriginalName(),
            'filepath' => $path,
            'user_id' => auth()->id(), // hubungkan ke user login
        ]);

        return back()->with('success', 'File berhasil diupload!');
    }

    public function destroy(Upload $upload)
    {
        // Hanya pemilik file atau admin yang boleh hapus
        if ($upload->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak berhak menghapus file ini.');
        }

        \Storage::delete('public/' . $upload->filepath);
        $upload->delete();

        return back()->with('success', 'File berhasil dihapus!');
    }
}
