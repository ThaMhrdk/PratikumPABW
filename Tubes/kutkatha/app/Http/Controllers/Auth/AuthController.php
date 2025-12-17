<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'psikolog' => redirect()->route('psikolog.dashboard'),
                'pemerintah' => redirect()->route('pemerintah.dashboard'),
                default => redirect()->route('user.dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showRoleSelection()
    {
        return view('auth.role-selection');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,psikolog',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // Jika register sebagai psikolog, buat record psikolog
        if ($request->role === 'psikolog') {
            $request->validate([
                'str_number' => 'required|string|unique:psikologs',
                'specialization' => 'required|string',
                'experience_years' => 'required|integer|min:0',
                'consultation_fee' => 'required|numeric|min:0',
                'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $certificatePath = null;
            if ($request->hasFile('certificate_file')) {
                $certificatePath = $request->file('certificate_file')->store('certificates', 'public');
            }

            Psikolog::create([
                'user_id' => $user->id,
                'str_number' => $request->str_number,
                'specialization' => $request->specialization,
                'experience_years' => $request->experience_years,
                'consultation_fee' => $request->consultation_fee,
                'certificate_document' => $certificatePath,
                'verification_status' => 'pending',
            ]);
        }

        Auth::login($user);

        return match($user->role) {
            'psikolog' => redirect()->route('psikolog.dashboard')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu verifikasi.'),
            default => redirect()->route('user.dashboard')->with('success', 'Registrasi berhasil!'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Untuk saat ini, tampilkan pesan sukses
        // Implementasi email reset password bisa ditambahkan nanti
        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}
