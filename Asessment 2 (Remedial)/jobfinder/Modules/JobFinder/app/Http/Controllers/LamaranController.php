<?php

namespace Modules\JobFinder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\JobFinder\Models\Lamaran;
use Modules\JobFinder\Models\Lowongan;

class LamaranController extends Controller
{
    /**
     * Menampilkan daftar lamaran
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Admin dapat melihat semua lamaran
            $daftarLamaran = Lamaran::with(['user', 'lowongan'])->latest()->get();
        } else {
            // Pelamar hanya melihat lamaran miliknya
            $daftarLamaran = Lamaran::with(['lowongan'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('jobfinder::lamaran.index', compact('daftarLamaran'));
    }

    /**
     * Form buat lamaran baru
     */
    public function create()
    {
        $daftarLowongan = Lowongan::all();
        return view('jobfinder::lamaran.create', compact('daftarLowongan'));
    }

    /**
     * Simpan lamaran baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'cv_file.mimes' => 'File CV harus berformat PDF, DOC, atau DOCX.',
            'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        $pathCV = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $namaFile = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $pathCV = $file->storeAs('cv', $namaFile, 'public');
        }

        $lamaran = Lamaran::create([
            'user_id' => Auth::id(),
            'lowongan_id' => $validatedData['lowongan_id'],
            'deskripsi_lamaran' => $validatedData['deskripsi_lamaran'],
            'cv_file' => $pathCV,
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dikirim!',
                'data' => $lamaran
            ]);
        }

        return redirect()->route('jobfinder.lamaran.index')
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Detail lamaran
     */
    public function show(Lamaran $lamaran)
    {
        // Cek hak akses
        if (Auth::user()->role !== 'admin' && $lamaran->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $lamaran->load(['user', 'lowongan']);
        return view('jobfinder::lamaran.show', compact('lamaran'));
    }

    /**
     * Form edit lamaran
     */
    public function edit(Lamaran $lamaran)
    {
        // Hanya pemilik yang dapat mengedit
        if ($lamaran->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $daftarLowongan = Lowongan::all();
        return view('jobfinder::lamaran.edit', compact('lamaran', 'daftarLowongan'));
    }

    /**
     * Update data lamaran
     */
    public function update(Request $request, Lamaran $lamaran)
    {
        // Hanya pemilik yang dapat mengupdate
        if ($lamaran->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $validatedData = $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('cv_file')) {
            // Hapus file lama jika ada
            if ($lamaran->cv_file) {
                Storage::disk('public')->delete($lamaran->cv_file);
            }
            $file = $request->file('cv_file');
            $namaFile = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $lamaran->cv_file = $file->storeAs('cv', $namaFile, 'public');
        }

        $lamaran->lowongan_id = $validatedData['lowongan_id'];
        $lamaran->deskripsi_lamaran = $validatedData['deskripsi_lamaran'];
        $lamaran->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil diperbarui!',
                'data' => $lamaran
            ]);
        }

        return redirect()->route('jobfinder.lamaran.index')
            ->with('success', 'Lamaran berhasil diperbarui!');
    }

    /**
     * Hapus lamaran (hanya admin)
     */
    public function destroy(Lamaran $lamaran)
    {
        // Hanya admin yang dapat menghapus
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Hapus file CV jika ada
        if ($lamaran->cv_file) {
            Storage::disk('public')->delete($lamaran->cv_file);
        }

        $lamaran->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dihapus!'
            ]);
        }

        return redirect()->route('jobfinder.lamaran.index')
            ->with('success', 'Lamaran berhasil dihapus!');
    }

    /**
     * Download file CV
     */
    public function downloadCV(Lamaran $lamaran)
    {
        // Cek hak akses
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->role !== 'admin' && $lamaran->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        if (!$lamaran->cv_file) {
            abort(404, 'File CV tidak ditemukan.');
        }

        $path = Storage::disk('public')->path($lamaran->cv_file);
        return response()->download($path);
    }
}
