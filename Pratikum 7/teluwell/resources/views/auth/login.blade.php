<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - TelU Well</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .login-container { max-width: 400px; background: var(--white); padding: 2.5rem; border-radius: var(--radius-xl); box-shadow: 0 20px 40px rgba(198, 40, 40, 0.3); border: 1px solid rgba(255,255,255,0.1); position: relative; }
        .login-container::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--primary-red), var(--accent-red), var(--primary-red)); border-radius: var(--radius-xl) var(--radius-xl) 0 0; }
        .login-container h2 { text-align: center; color: var(--primary-red); margin-bottom: 2rem; font-size: 2rem; text-shadow: 0 2px 4px rgba(198, 40, 40, 0.1); }
        .logo-section { text-align: center; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--dark-gray); font-size: 0.9rem; }
        .form-group input, .form-group select { width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--border-gray); border-radius: var(--radius-md); font-size: 1rem; transition: all 0.3s ease; background: var(--white); font-family: inherit; box-sizing: border-box; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--primary-red); box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.2); }
        .btn-login { width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, var(--primary-red) 0%, var(--accent-red) 100%); color: var(--white); border: none; border-radius: var(--radius-md); font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(198, 40, 40, 0.3); }
        .btn-login:hover { background: linear-gradient(135deg, var(--dark-red) 0%, var(--primary-red) 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(198, 40, 40, 0.4); }
        .register-link { text-align: center; margin-top: 1.5rem; }
        .register-link a { color: var(--primary-red); text-decoration: none; font-weight: 500; transition: all 0.3s ease; }
        .register-link a:hover { text-decoration: underline; color: var(--dark-red); }
        .role-info { font-size: 0.9rem; color: var(--gray); margin-top: 0.5rem; font-style: italic; }
        .message { padding: 1rem; margin-bottom: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-red); }
        .message-success { background: #d4edda; color: #155724; border-color: #c3e6cb; }
        .message-error { background: #f8d7da; color: #721c24; border-color: #f5c6cb; }
    </style>
</head>
<body style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">

<div class="login-container">
    <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="TelU Well Logo" style="height: 80px; width: auto; margin-bottom: 1rem; border-radius: 8px;" />
        <h2>Login TelU Well</h2>
    </div>

    @if (session('message'))
        <div class="message message-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="message message-error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="role">Login Sebagai:</label>
            <select id="role" name="role" required onchange="updateLoginForm()">
                <option value="">Pilih Role</option>
                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="konselor" {{ old('role') == 'konselor' ? 'selected' : '' }}>Konselor</option>
            </select>
        </div>

        <div class="form-group">
            <label for="username" id="username-label">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            <div class="role-info" id="username-info"></div>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn-login">
            Masuk
        </button>
    </form>

    <div class="register-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
</div>

<script>
function updateLoginForm() {
    const role = document.getElementById('role').value;
    const usernameLabel = document.getElementById('username-label');
    const usernameInfo = document.getElementById('username-info');
    const usernameInput = document.getElementById('username');
    
    if (role === 'mahasiswa') {
        usernameLabel.textContent = 'NIM:';
        usernameInfo.textContent = 'Masukkan NIM Anda';
        usernameInput.placeholder = 'Contoh: 1301190001';
        usernameInput.setAttribute('pattern', '\\d{8,15}');
        usernameInput.setAttribute('maxlength', '15');
    } else if (role === 'konselor') {
        usernameLabel.textContent = 'Email:';
        usernameInfo.textContent = 'Masukkan email konselor Anda';
        usernameInput.placeholder = 'Masukkan email';
        usernameInput.removeAttribute('pattern');
        usernameInput.removeAttribute('maxlength');
    } else {
        usernameLabel.textContent = 'Username:';
        usernameInfo.textContent = '';
        usernameInput.placeholder = '';
        usernameInput.removeAttribute('pattern');
        usernameInput.removeAttribute('maxlength');
    }
}
document.addEventListener('DOMContentLoaded', updateLoginForm);
</script>

</body>
</html>