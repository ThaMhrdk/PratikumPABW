<?php

namespace Modules\JobFinder\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekPelamar
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'pelamar') {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Hanya pelamar yang diizinkan.'
            ], 403);
        }

        return redirect()->route('jobfinder.dashboard')
            ->with('error', 'Akses ditolak. Hanya pelamar yang diizinkan.');
    }
}
