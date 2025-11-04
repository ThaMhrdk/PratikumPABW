<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'in:mahasiswa,konselor'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $role = $request->input('role');
        $username = $request->input('username');
        $password = $request->input('password');

        $credentials = [];
        $guard = '';

        if ($role === 'mahasiswa') {
            $guard = 'mahasiswa';
            $credentials = [
                'nim' => $username,
                'password' => $password
            ];
        } elseif ($role === 'konselor') {
            $guard = 'konselor';
            $credentials = [
                'emailkons' => $username,
                'password' => $password
            ];
        }

        if (Auth::guard($guard)->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $request->session()->put('role', $guard);
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Login gagal. Periksa kembali input Anda.',
        ])->withInput($request->only('username', 'role'));
    }

    public function destroy(Request $request)
    {
        $role = $request->session()->get('role', 'web');
        
        Auth::guard($role)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Anda telah berhasil logout.');
    }
}