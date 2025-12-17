<?php

namespace Modules\JobFinder\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\JobFinder\App\Models\Lamaran;
use Modules\JobFinder\App\Models\Lowongan;

class LamaranController extends BaseController
{
    /**
     * Tampilkan halaman daftar lamaran (AJAX View)
     */
    public function index()
    {
        $user = Auth::user();
        $lowongan = Lowongan::all();

        return view('jobfinder::lamaran.index', compact('lowongan'));
    }

    /**
     * Ambil data lamaran (JSON untuk AJAX)
     */
    public function getData(): JsonResponse
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin bisa lihat semua lamaran
            $data = Lamaran::with(['user', 'lowongan'])->latest()->get();
        } else {
            // Pelamar hanya bisa lihat lamarannya sendiri
            $data = Lamaran::with(['user', 'lowongan'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return response()->json($data);
    }

    /**
     * Simpan atau update data lamaran dengan upload CV
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'lowongan_id' => 'required|exists:lowongan,id',
            'deskripsi_lamaran' => 'required|string',
        ];

        // Validasi file CV hanya jika ada file baru yang diupload
        if ($request->hasFile('cv_file')) {
            $rules['cv_file'] = 'required|mimes:pdf,doc,docx|max:2048';
        }

        $request->validate($rules);

        $user = Auth::user();

        // Cek apakah pelamar sudah melamar lowongan ini
        if (!$request->id) {
            $existingLamaran = Lamaran::where('user_id', $user->id)
                ->where('lowongan_id', $request->lowongan_id)
                ->first();

            if ($existingLamaran) {
                return response()->json(['error' => 'Anda sudah melamar untuk lowongan ini!'], 422);
            }
        }

        $data = [
            'user_id' => $user->id,
            'lowongan_id' => $request->lowongan_id,
            'deskripsi_lamaran' => $request->deskripsi_lamaran,
        ];

        // Handle upload file CV
        if ($request->hasFile('cv_file')) {
            // Hapus file lama jika update
            if ($request->id) {
                $oldLamaran = Lamaran::find($request->id);
                if ($oldLamaran && $oldLamaran->cv_file) {
                    Storage::disk('public')->delete($oldLamaran->cv_file);
                }
            }

            $file = $request->file('cv_file');
            $fileName = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cv', $fileName, 'public');
            $data['cv_file'] = $path;
        }

        Lamaran::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return response()->json(['success' => 'Lamaran berhasil disimpan!']);
    }

    /**
     * Ambil satu data untuk edit
     */
    public function edit($id): JsonResponse
    {
        $user = Auth::user();
        $lamaran = Lamaran::with(['user', 'lowongan'])->findOrFail($id);

        // Cek otorisasi (hanya pemilik atau admin)
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($lamaran);
    }

    /**
     * Hapus data lamaran (hanya admin)
     */
    public function destroy($id): JsonResponse
    {
        $user = Auth::user();
        $lamaran = Lamaran::findOrFail($id);

        // Hanya admin atau pemilik yang bisa hapus
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Hapus file CV jika ada
        if ($lamaran->cv_file) {
            Storage::disk('public')->delete($lamaran->cv_file);
        }

        $lamaran->delete();
        return response()->json(['success' => 'Lamaran berhasil dihapus!']);
    }

    /**
     * Update status lamaran (hanya admin)
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak'
        ]);

        $lamaran = Lamaran::findOrFail($id);
        $lamaran->update(['status' => $request->status]);

        return response()->json(['success' => 'Status lamaran berhasil diperbarui!']);
    }

    /**
     * Download file CV
     */
    public function downloadCV($id)
    {
        $user = Auth::user();
        $lamaran = Lamaran::findOrFail($id);

        // Cek otorisasi
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if (!$lamaran->cv_file) {
            abort(404, 'File tidak ditemukan');
        }

        $path = storage_path('app/public/' . $lamaran->cv_file);
        return response()->download($path);
    }
}
