<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - TelU Well</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
     <style>
        .register-container { max-width: 500px; background: var(--white); padding: 2.5rem; border-radius: var(--radius-xl); box-shadow: 0 20px 40px rgba(198, 40, 40, 0.3); border: 1px solid rgba(255,255,255,0.1); margin: 1rem; position: relative; }
        .register-container::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--primary-red), var(--accent-red), var(--primary-red)); border-radius: var(--radius-xl) var(--radius-xl) 0 0; }
        .register-container h2 { text-align: center; color: var(--primary-red); margin-bottom: 2rem; font-size: 2rem; text-shadow: 0 2px 4px rgba(198, 40, 40, 0.1); }
        .logo-section { text-align: center; margin-bottom: 2rem; }
        .form-row { display: flex; gap: 1rem; }
        .form-group { margin-bottom: 1.5rem; flex: 1; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--dark-gray); font-size: 0.9rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--border-gray); border-radius: var(--radius-md); font-size: 1rem; transition: all 0.3s ease; background: var(--white); font-family: inherit; box-sizing: border-box; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--primary-red); box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.2); }
        .btn-register { width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, var(--primary-red) 0%, var(--accent-red) 100%); color: var(--white); border: none; border-radius: var(--radius-md); font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(198, 40, 40, 0.3); }
        .btn-register:hover { background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(198, 40, 40, 0.4); }
        .login-link { text-align: center; margin-top: 1.5rem; }
        .login-link a { color: var(--primary-red); text-decoration: none; font-weight: 500; transition: all 0.3s ease; }
        .login-link a:hover { text-decoration: underline; color: var(--dark-red); }
        .message { padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-red); }
        .message-success { background: #d4edda; color: #155724; border-color: #c3e6cb; }
        .message-error { background: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        @media (max-width: 768px) { .form-row { flex-direction: column; gap: 0; } .register-container { padding: 1.5rem; } }
    </style>
</head>
<body style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 0;">

<div class="register-container">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="TelU Well Logo" style="height: 80px; width: auto; margin-bottom: 1rem; border-radius: 8px;" />
        <h2>Registrasi Mahasiswa</h2>
    </div>

    @if ($errors->any())
        <div class="message message-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" required maxlength="15" pattern="\d{8,15}" 
                   value="{{ old('nim') }}"
                   placeholder="Contoh: 1301190001">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required value="{{ old('email') }}">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="nmdepan">Nama Depan:</label>
                <input type="text" id="nmdepan" name="nmdepan" required 
                       value="{{ old('nmdepan') }}">
            </div>
            <div class="form-group">
                <label for="nmbelakang">Nama Belakang:</label>
                <input type="text" id="nmbelakang" name="nmbelakang" 
                       value="{{ old('nmbelakang') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="jk">Jenis Kelamin:</label>
            <select id="jk" name="jk" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('jk') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="prodi">Program Studi:</label>
            <select id="prodi" name="prodi" required>
                <option value="">Pilih Program Studi</option>
                @php $current_fakultas = ''; @endphp
                @foreach ($prodi_list as $prodi)
                    @if ($current_fakultas !== $prodi['nmfakultas'])
                        @if ($current_fakultas !== '') </optgroup> @endif
                        <optgroup label="{{ htmlspecialchars($prodi['nmfakultas']) }}">
                        @php $current_fakultas = $prodi['nmfakultas']; @endphp
                    @endif
                    <option value="{{ $prodi['Idprodi'] }}" {{ old('prodi') == $prodi['Idprodi'] ? 'selected' : '' }}>
                        {{ htmlspecialchars($prodi['nmprodi'] . ' (' . $prodi['jenjang'] . ')') }}
                    </option>
                @endforeach
                @if ($current_fakultas !== '') </optgroup> @endif
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="3">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="3">
            </div>
        </div>

        <button type="submit" class="btn-register">
            Daftar
        </button>
    </form>

    <div class="login-link">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </div>
</div>

</body>
</html>