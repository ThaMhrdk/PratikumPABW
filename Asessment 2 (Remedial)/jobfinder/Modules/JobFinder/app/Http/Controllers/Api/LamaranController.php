<?php

namespace Modules\JobFinder\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\JobFinder\Http\Controllers\Controller;
use Modules\JobFinder\Models\Lamaran;
use Modules\JobFinder\Models\Lowongan;

class LamaranController extends Controller
{
    /**
     * Daftar semua lamaran
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'admin') {
            $daftarLamaran = Lamaran::with(['user', 'lowongan'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $daftarLamaran = Lamaran::with(['lowongan'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $daftarLamaran
        ]);
    }

    /**
     * Simpan lamaran baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'cv_file.required' => 'File CV wajib diunggah.',
            'cv_file.mimes' => 'File CV harus berformat PDF, DOC, atau DOCX.',
            'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        $pathCV = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $namaFile = time() . '_' . $request->user()->id . '_' . $file->getClientOriginalName();
            $pathCV = $file->storeAs('cv', $namaFile, 'public');
        }

        $lamaran = Lamaran::create([
            'user_id' => $request->user()->id,
            'lowongan_id' => $validatedData['lowongan_id'],
            'deskripsi_lamaran' => $validatedData['deskripsi_lamaran'],
            'cv_file' => $pathCV,
        ]);

        $lamaran->load(['lowongan']);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim!',
            'data' => $lamaran
        ], 201);
    }

    /**
     * Detail lamaran
     */
    public function show(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Cek akses
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke lamaran ini.'
            ], 403);
        }

        $lamaran->load(['user', 'lowongan']);

        return response()->json([
            'success' => true,
            'data' => $lamaran
        ]);
    }

    /**
     * Update lamaran
     */
    public function update(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Hanya pemilik yang dapat mengupdate
        if ($lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengedit lamaran ini.'
            ], 403);
        }

        $validatedData = $request->validate([
            'lowongan_id' => 'sometimes|required|exists:lowongans,id',
            'deskripsi_lamaran' => 'sometimes|required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = collect($validatedData)->only(['lowongan_id', 'deskripsi_lamaran'])->toArray();

        if ($request->hasFile('cv_file')) {
            // Hapus file lama
            if ($lamaran->cv_file) {
                Storage::disk('public')->delete($lamaran->cv_file);
            }
            
            $file = $request->file('cv_file');
            $namaFile = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
            $data['cv_file'] = $file->storeAs('cv', $namaFile, 'public');
        }

        $lamaran->update($data);
        $lamaran->load(['lowongan']);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil diperbarui!',
            'data' => $lamaran
        ]);
    }

    /**
     * Hapus lamaran (hanya admin)
     */
    public function destroy(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Hanya admin yang dapat menghapus
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat menghapus lamaran.'
            ], 403);
        }

        // Hapus file CV
        if ($lamaran->cv_file) {
            Storage::disk('public')->delete($lamaran->cv_file);
        }

        $lamaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dihapus!'
        ]);
    }

    /**
     * Upload file CV untuk lamaran yang sudah ada
     */
    public function uploadCV(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Hanya pemilik yang dapat upload
        if ($lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke lamaran ini.'
            ], 403);
        }

        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'cv_file.required' => 'File CV wajib diunggah.',
            'cv_file.mimes' => 'File CV harus berformat PDF, DOC, atau DOCX.',
            'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        // Hapus file lama
        if ($lamaran->cv_file) {
            Storage::disk('public')->delete($lamaran->cv_file);
        }

        $file = $request->file('cv_file');
        $namaFile = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
        $pathCV = $file->storeAs('cv', $namaFile, 'public');

        $lamaran->update(['cv_file' => $pathCV]);

        return response()->json([
            'success' => true,
            'message' => 'CV berhasil diunggah!',
            'data' => [
                'cv_file' => $pathCV,
                'cv_url' => asset('storage/' . $pathCV)
            ]
        ]);
    }

    /**
     * Ambil daftar lowongan untuk dropdown
     */
    public function getLowongan()
    {
        $daftarLowongan = Lowongan::orderBy('posisi', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $daftarLowongan
        ]);
    }
}
