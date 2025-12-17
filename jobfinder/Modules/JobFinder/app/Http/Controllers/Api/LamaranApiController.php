<?php

namespace Modules\JobFinder\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\JobFinder\App\Models\Lamaran;
use Modules\JobFinder\App\Models\Lowongan;
use Modules\JobFinder\App\Http\Controllers\BaseController;

class LamaranApiController extends BaseController
{
    /**
     * Tampilkan semua lamaran
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $lamaran = Lamaran::with(['user', 'lowongan'])->latest()->paginate(10);
        } else {
            $lamaran = Lamaran::with(['user', 'lowongan'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        }

        return response()->json([
            'success' => true,
            'data' => $lamaran
        ]);
    }

    /**
     * Simpan lamaran baru
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'lowongan_id' => 'required|exists:lowongan,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Cek apakah sudah melamar lowongan ini
        $existingLamaran = Lamaran::where('user_id', $user->id)
            ->where('lowongan_id', $request->lowongan_id)
            ->first();

        if ($existingLamaran) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melamar untuk lowongan ini!'
            ], 422);
        }

        // Upload file CV
        $file = $request->file('cv_file');
        $fileName = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('cv', $fileName, 'public');

        $lamaran = Lamaran::create([
            'user_id' => $user->id,
            'lowongan_id' => $request->lowongan_id,
            'deskripsi_lamaran' => $request->deskripsi_lamaran,
            'cv_file' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil disimpan!',
            'data' => $lamaran->load(['user', 'lowongan'])
        ], 201);
    }

    /**
     * Tampilkan detail lamaran
     */
    public function show(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $lamaran = Lamaran::with(['user', 'lowongan'])->find($id);

        if (!$lamaran) {
            return response()->json([
                'success' => false,
                'message' => 'Lamaran tidak ditemukan'
            ], 404);
        }

        // Cek otorisasi
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $lamaran
        ]);
    }

    /**
     * Update lamaran
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $lamaran = Lamaran::find($id);

        if (!$lamaran) {
            return response()->json([
                'success' => false,
                'message' => 'Lamaran tidak ditemukan'
            ], 404);
        }

        // Cek otorisasi
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $rules = [
            'deskripsi_lamaran' => 'sometimes|required|string',
        ];

        if ($request->hasFile('cv_file')) {
            $rules['cv_file'] = 'mimes:pdf,doc,docx|max:2048';
        }

        // Admin bisa update status
        if ($user->role === 'admin') {
            $rules['status'] = 'sometimes|in:pending,diterima,ditolak';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [];

        if ($request->has('deskripsi_lamaran')) {
            $data['deskripsi_lamaran'] = $request->deskripsi_lamaran;
        }

        if ($request->has('status') && $user->role === 'admin') {
            $data['status'] = $request->status;
        }

        // Handle upload file CV baru
        if ($request->hasFile('cv_file')) {
            // Hapus file lama
            if ($lamaran->cv_file) {
                Storage::disk('public')->delete($lamaran->cv_file);
            }

            $file = $request->file('cv_file');
            $fileName = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cv', $fileName, 'public');
            $data['cv_file'] = $path;
        }

        $lamaran->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil diupdate!',
            'data' => $lamaran->fresh()->load(['user', 'lowongan'])
        ]);
    }

    /**
     * Hapus lamaran
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $lamaran = Lamaran::find($id);

        if (!$lamaran) {
            return response()->json([
                'success' => false,
                'message' => 'Lamaran tidak ditemukan'
            ], 404);
        }

        // Cek otorisasi
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
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
     * Download CV
     */
    public function downloadCV(Request $request, $id)
    {
        $user = $request->user();
        $lamaran = Lamaran::find($id);

        if (!$lamaran) {
            return response()->json([
                'success' => false,
                'message' => 'Lamaran tidak ditemukan'
            ], 404);
        }

        // Cek otorisasi
        if ($user->role !== 'admin' && $lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        if (!$lamaran->cv_file || !Storage::disk('public')->exists($lamaran->cv_file)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        $path = storage_path('app/public/' . $lamaran->cv_file);
        return response()->download($path);
    }
}
