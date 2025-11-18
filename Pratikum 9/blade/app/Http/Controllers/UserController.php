<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak berhak menghapus user.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Admin tidak boleh menghapus dirinya sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}
