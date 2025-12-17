<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $lamarans = Lamaran::with(['user', 'lowongan'])->latest()->get();
        } else {
            $lamarans = Lamaran::with(['lowongan'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('lamaran.index', compact('lamarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lowongans = Lowongan::all();
        return view('lamaran.create', compact('lowongans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [
            'cv_file.mimes' => 'File CV harus berformat PDF, DOC, atau DOCX.',
            'cv_file.max' => 'Ukuran file CV maksimal 5MB.',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $cvPath = $file->storeAs('cv', $filename, 'public');
        }

        $lamaran = Lamaran::create([
            'user_id' => Auth::id(),
            'lowongan_id' => $request->lowongan_id,
            'deskripsi_lamaran' => $request->deskripsi_lamaran,
            'cv_file' => $cvPath,
        ]);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dikirim!',
                'data' => $lamaran
            ]);
        }

        return redirect()->route('lamaran.index')
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lamaran $lamaran)
    {
        // Check access rights
        if (Auth::user()->role !== 'admin' && $lamaran->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $lamaran->load(['user', 'lowongan']);
        return view('lamaran.show', compact('lamaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lamaran $lamaran)
    {
        // Only owner can edit
        if ($lamaran->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $lowongans = Lowongan::all();
        return view('lamaran.edit', compact('lamaran', 'lowongans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lamaran $lamaran)
    {
        // Only owner can update
        if ($lamaran->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
            'deskripsi_lamaran' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('cv_file')) {
            // Delete old file
            if ($lamaran->cv_file) {
                Storage::disk('public')->delete($lamaran->cv_file);
            }
            $file = $request->file('cv_file');
            $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $lamaran->cv_file = $file->storeAs('cv', $filename, 'public');
        }

        $lamaran->lowongan_id = $request->lowongan_id;
        $lamaran->deskripsi_lamaran = $request->deskripsi_lamaran;
        $lamaran->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil diperbarui!',
                'data' => $lamaran
            ]);
        }

        return redirect()->route('lamaran.index')
            ->with('success', 'Lamaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lamaran $lamaran)
    {
        // Only admin can delete
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // Delete CV file
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

        return redirect()->route('lamaran.index')
            ->with('success', 'Lamaran berhasil dihapus!');
    }

    /**
     * Download CV file
     */
    public function downloadCV(Lamaran $lamaran)
    {
        if (Auth::user()->role !== 'admin' && $lamaran->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if (!$lamaran->cv_file) {
            abort(404, 'File CV tidak ditemukan.');
        }

        return Storage::disk('public')->download($lamaran->cv_file);
    }
}
