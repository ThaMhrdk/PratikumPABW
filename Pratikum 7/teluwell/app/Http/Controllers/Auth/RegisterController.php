<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function create()
    {
        $prodi_list = Prodi::select('prodi.Idprodi', 'prodi.nmprodi', 'prodi.jenjang', 'fakultas.nmfakultas')
                            ->join('fakultas', 'prodi.Idfakultas', '=', 'fakultas.Idfakultas')
                            ->orderBy('fakultas.nmfakultas')
                            ->orderBy('prodi.nmprodi')
                            ->get();

        return view('auth.register', ['prodi_list' => $prodi_list]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => ['required', 'string', 'max:15', 'regex:/^\d{8,15}$/', 'unique:mahasiswa,nim'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:mahasiswa,email'],
            'nmdepan' => ['required', 'string', 'max:25'],
            'nmbelakang' => ['nullable', 'string', 'max:25'],
            'jk' => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'prodi' => ['required', 'string', 'exists:prodi,Idprodi'],
            'password' => ['required', 'confirmed', Rules\Password::min(3)],
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'email' => $request->email,
            'nmdepan' => $request->nmdepan,
            'nmbelakang' => $request->nmbelakang,
            'jk' => $request->jk,
            'Idprodi' => $request->prodi,
            'password' => Hash::make($request->password),
        ]);
        
        $message = "Registrasi berhasil! Silakan login dengan NIM: " . $request->nim;
        return redirect()->route('login')->with('message', $message);
    }
}