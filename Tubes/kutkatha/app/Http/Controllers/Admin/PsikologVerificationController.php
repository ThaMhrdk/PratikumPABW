<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Psikolog;
use Illuminate\Http\Request;

class PsikologVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Psikolog::with('user');

        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        $psikologs = $query->orderBy('created_at', 'desc')->paginate(15);

        $pendingCount = Psikolog::where('verification_status', 'pending')->count();
        $verifiedCount = Psikolog::where('verification_status', 'verified')->count();
        $rejectedCount = Psikolog::where('verification_status', 'rejected')->count();

        return view('admin.verification.index', compact('psikologs', 'pendingCount', 'verifiedCount', 'rejectedCount'));
    }

    public function show(Psikolog $psikolog)
    {
        $psikolog->load('user');

        return view('admin.verification.show', compact('psikolog'));
    }

    public function verify(Psikolog $psikolog)
    {
        $psikolog->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Psikolog berhasil diverifikasi.');
    }

    public function reject(Request $request, Psikolog $psikolog)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $psikolog->update([
            'verification_status' => 'rejected',
        ]);

        // TODO: Send notification email with rejection reason

        return back()->with('success', 'Psikolog ditolak.');
    }
}
