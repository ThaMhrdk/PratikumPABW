<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'admin') {
            $lamarans = Lamaran::with(['user', 'lowongan'])->orderBy('created_at', 'desc')->get();
        } else {
            $lamarans = Lamaran::with(['lowongan'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $lamarans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'cv_file.required' => 'File CV wajib diunggah.',
            'cv_file.mimes' => 'File CV harus berformat PDF, DOC, atau DOCX.',
            'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $filename = time() . '_' . $request->user()->id . '_' . $file->getClientOriginalName();
            $cvPath = $file->storeAs('cv', $filename, 'public');
        }

        $lamaran = Lamaran::create([
            'user_id' => $request->user()->id,
            'lowongan_id' => $request->lowongan_id,
            'deskripsi_lamaran' => $request->deskripsi_lamaran,
            'cv_file' => $cvPath,
        ]);

        $lamaran->load(['lowongan']);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim!',
            'data' => $lamaran
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Check access
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Only owner can update
        if ($lamaran->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengedit lamaran ini.'
            ], 403);
        }

        $request->validate([
            'lowongan_id' => 'sometimes|required|exists:lowongans,id',
            'deskripsi_lamaran' => 'sometimes|required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only(['lowongan_id', 'deskripsi_lamaran']);

        if ($request->hasFile('cv_file')) {
            // Delete old file
            if ($lamaran->cv_file) {
                Storage::disk('public')->delete($lamaran->cv_file);
            }
            
            $file = $request->file('cv_file');
            $filename = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
            $data['cv_file'] = $file->storeAs('cv', $filename, 'public');
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Only admin can delete
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat menghapus lamaran.'
            ], 403);
        }

        // Delete CV file
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
     * Upload CV file for existing lamaran
     */
    public function uploadCV(Request $request, Lamaran $lamaran)
    {
        $user = $request->user();
        
        // Only owner can upload
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

        // Delete old file
        if ($lamaran->cv_file) {
            Storage::disk('public')->delete($lamaran->cv_file);
        }

        $file = $request->file('cv_file');
        $filename = time() . '_' . $user->id . '_' . $file->getClientOriginalName();
        $cvPath = $file->storeAs('cv', $filename, 'public');

        $lamaran->update(['cv_file' => $cvPath]);

        return response()->json([
            'success' => true,
            'message' => 'CV berhasil diunggah!',
            'data' => [
                'cv_file' => $cvPath,
                'cv_url' => asset('storage/' . $cvPath)
            ]
        ]);
    }

    /**
     * Get all available lowongan for dropdown
     */
    public function getLowongan()
    {
        $lowongans = Lowongan::orderBy('posisi', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $lowongans
        ]);
    }
}
