# LAPORAN PRAKTIKUM PEMROGRAMAN APLIKASI BERBASIS WEB
## PROJECT REMEDIAL: APLIKASI PORTAL LOWONGAN KERJA "JOBFINDER"

**Disusun Oleh:**

| Nama | [Isi Nama Lengkap Anda] |
| :--- | :--- |
| **NIM** | **[Isi NIM Anda]** |
| **Kelas** | **[Isi Kelas Anda]** |
| **Program Studi** | **[Isi Prodi Anda]** |
| **Fakultas** | **[Isi Fakultas Anda]** |

---

## KATA PENGANTAR

Puji syukur kehadirat Tuhan Yang Maha Esa atas rahmat dan karunia-Nya, sehingga penulis dapat menyelesaikan laporan praktikum Pemrograman Aplikasi Berbasis Web ini dengan judul "Aplikasi Portal Lowongan Kerja JobFinder". Laporan ini disusun untuk memenuhi tugas remedial mata kuliah Pemrograman Aplikasi Berbasis Web.

Penulis menyadari bahwa masih banyak kekurangan dalam penyusunan laporan ini. Oleh karena itu, penulis mengharapkan kritik dan saran yang membangun untuk perbaikan di masa mendatang.

[Kota, Tanggal Bulan Tahun]

Penulis

---

## DAFTAR ISI

1.  **BAB I PENDAHULUAN**
    *   1.1 Latar Belakang
    *   1.2 Rumusan Masalah
    *   1.3 Tujuan
    *   1.4 Manfaat
    *   1.5 Alat dan Bahan
2.  **BAB II DASAR TEORI**
    *   2.1 Framework Laravel
    *   2.2 Konsep MVC (Model-View-Controller)
    *   2.3 Authentication & Authorization
    *   2.4 REST API
3.  **BAB III PEMBAHASAN DAN IMPLEMENTASI**
    *   3.1 Instalasi dan Konfigurasi Awal
    *   3.2 Perancangan Database & Migration
    *   3.3 Implementasi Model
    *   3.4 Implementasi Autentikasi & Middleware
    *   3.5 Implementasi Controller
    *   3.6 Implementasi Views (Antarmuka)
    *   3.7 Implementasi Routes
    *   3.8 Implementasi API
4.  **BAB IV PENGUJIAN SISTEM**
    *   4.1 Uji Coba Login dan Registrasi
    *   4.2 Uji Coba Dashboard
    *   4.3 Uji Coba Manajemen Lowongan (CRUD)
    *   4.4 Uji Coba Melamar Pekerjaan
5.  **BAB V ANALISIS DAN PENUTUP**
    *   5.1 Analisis Sistem
    *   5.2 Kesimpulan
    *   5.3 Saran
6.  **DAFTAR PUSTAKA**

---

## BAB I: PENDAHULUAN

### 1.1 Latar Belakang
Di era digitalisasi saat ini, kebutuhan akan efisiensi penyebaran informasi sangat tinggi, termasuk informasi mengenai lowongan pekerjaan. Proses manual dalam penyebaran dan pelamaran kerja seringkali tidak efisien. Oleh karena itu, diperlukan sebuah sistem berbasis web yang dapat memfasilitasi pertemuan antara penyedia kerja (perusahaan) dan pencari kerja. Project "JobFinder" ini dibangun menggunakan Framework Laravel 11 yang menawarkan keamanan, kemudahan, dan struktur kode yang rapi untuk menjawab kebutuhan tersebut.

### 1.2 Rumusan Masalah
1.  Bagaimana membangun sistem autentikasi yang aman untuk membedakan antara Admin dan Pelamar?
2.  Bagaimana mengelola data lowongan pekerjaan (CRUD) secara efektif?
3.  Bagaimana memfasilitasi proses pelamaran kerja inculding upload berkas CV secara digital?
4.  Bagaimana menyediakan akses data melalui API untuk kebutuhan integrasi sistem lain?

### 1.3 Tujuan
1.  Membuat aplikasi web dengan fitur autentikasi (Login, Register, Logout) menggunakan Laravel Breeze.
2.  Menerapkan hak akses user (Role-Based Access Control) untuk membatasi akses Admin dan Pelamar.
3.  Mengimplementasikan fitur CRUD (*Create, Read, Update, Delete*) pada data Lowongan Pekerjaan.
4.  Menyediakan fitur upload file CV bagi pelamar.
5.  Membangun REST API sederhana untuk data lamaran.

### 1.4 Alat dan Bahan
*   **Laptop/PC**: Windows 10/11
*   **Text Editor**: Visual Studio Code
*   **Web Server**: XAMPP (Apache & MySQL)
*   **Bahasa Pemrograman**: PHP > 8.2
*   **Framework**: Laravel 11
*   **Database Management**: phpMyAdmin / DBeaver

---

## BAB II: DASAR TEORI

### 2.1 Framework Laravel
Laravel adalah kerangka kerja aplikasi web berbasis PHP yang sumber terbuka (open-source), menggunakan konsep Model-View-Controller. Laravel dikenal dengan sintaksis yang ekspresif dan elegan, serta menyediakan berbagai fitur bawaan seperti autentikasi, routing, sesi, dan caching yang mempercepat proses pengembangan.

### 2.2 Konsep MVC
MVC adalah pola arsitektur perangkat lunak yang memisahkan aplikasi menjadi tiga komponen utama:
*   **Model**: Bertugas mengelola data dan logika bisnis (berhubungan langsung dengan database).
*   **View**: Bertugas menangani tampilan antarmuka kepada pengguna (UI).
*   **Controller**: Bertugas menghubungkan Model dan View, menerima request dari user, memprosesnya, dan mengembalikan respon.

### 2.3 Authentication & Authorization
Authentication adalah proses verifikasi identitas pengguna (siapa Anda?), sedangkan Authorization adalah proses verifikasi hak akses pengguna (apa yang boleh Anda lakukan?). Dalam Laravel, fitur ini dapat diimplementasikan menggunakan starter kit seperti Laravel Breeze dan Middleware.

---

## BAB III: PEMBAHASAN DAN IMPLEMENTASI

### 3.1 Instalasi dan Konfigurasi Awal

**Step 1: Instalasi Laravel**
Jalankan perintah berikut di terminal untuk membuat project baru:

```bash
composer create-project laravel/laravel jobfinder
cd jobfinder
```

**Step 2: Konfigurasi Database**
Edit file `.env` untuk menghubungkan aplikasi dengan database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobfinder
DB_USERNAME=root
DB_PASSWORD=
```

### 3.2 Perancangan Database & Migration

**Step 1: Menambahkan Role pada Users**
Buat migration baru untuk menambahkan kolom role:

```bash
php artisan make:migration add_role_to_users_table --table=users
```

Edit migration `database/migrations/xxxx_xx_xx_add_role_to_users_table.php`:

```php
public function up(): void {
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'pelamar'])->default('pelamar')->after('email');
    });
}

public function down(): void {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
```

**Step 2: Model Lowongan (Job Listings)**
Buat model beserta file migration:

```bash
php artisan make:model Lowongan -m
```

Edit migration `database/migrations/xxxx_xx_xx_create_lowongans_table.php`:

```php
public function up(): void {
    Schema::create('lowongans', function (Blueprint $table) {
        $table->id();
        $table->string('posisi');
        $table->string('perusahaan');
        $table->string('lokasi_kerja');
        $table->text('deskripsi')->nullable();
        $table->integer('gaji')->nullable();
        $table->timestamps();
    });
}
```

**Step 3: Model Lamaran (Job Applications)**
Buat model beserta file migration:

```bash
php artisan make:model Lamaran -m
```

Edit migration `database/migrations/xxxx_xx_xx_create_lamarans_table.php`:

```php
public function up(): void {
    Schema::create('lamarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
        $table->text('deskripsi_lamaran');
        $table->string('cv_file')->nullable();
        $table->timestamps();
    });
}
```

**Step 4: Menjalankan Migration**
Eksekusi perintah berikut untuk membuat tabel di database:

```bash
php artisan migrate
```

### 3.3 Implementasi Model

**Step 1: Update Model User**
Edit file `app/Models/User.php` untuk menambahkan relasi:

```php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahan kolom role
    ];

    // Relasi One-to-Many ke Lamaran
    public function lamarans()
    {
        return $this->hasMany(\App\Models\Lamaran::class);
    }
}
```

**Step 2: Update Model Lowongan**
Edit file `app/Models/Lowongan.php`:

```php
class Lowongan extends Model
{
    protected $fillable = [
        'posisi', 'perusahaan', 'lokasi_kerja',
        'deskripsi', 'gaji',
    ];

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}
```

**Step 3: Update Model Lamaran**
Edit file `app/Models/Lamaran.php`:

```php
class Lamaran extends Model
{
    protected $fillable = [
        'user_id', 'lowongan_id',
        'deskripsi_lamaran', 'cv_file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
```

### 3.4 Implementasi Autentikasi & Middleware

**Step 1: Instalasi Laravel Breeze**
Gunakan perintah berikut untuk scaffolding autentikasi:

```bash
composer require laravel/breeze --dev
php artisan breeze:install
```

**Step 2: Membuat RoleMiddleware**
Buat middleware untuk membatasi akses:

```bash
php artisan make:middleware RoleMiddleware
```

Edit file `app/Http/Middleware/RoleMiddleware.php`:

```php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    // Cek apakah user sudah login
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $userRole = auth()->user()->role;
    
    // Cek apakah role user ada dalam daftar role yang diperbolehkan
    if (!in_array($userRole, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    return $next($request);
}
```

**Step 3: Registrasi Middleware**
Daftarkan middleware di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

### 3.5 Implementasi Controller

**Step 1: Membuat Controller**
Jalankan perintah:

```bash
php artisan make:controller LowonganController
php artisan make:controller LamaranController
php artisan make:controller DashboardController
```

**Step 2: LowonganController (Admin)**
Edit file `app/Http/Controllers/LowonganController.php`:

```php
// App/Http/Controllers/LowonganController.php
public function index(Request $request) {
    if ($request->ajax()) {
        $lowongans = Lowongan::latest()->get();
        return response()->json(['data' => $lowongans]);
    }
    return view('lowongan.index');
}

public function create() {
    return view('lowongan.create');
}

public function store(Request $request) {
    $request->validate([
        'posisi' => 'required|string|max:255',
        'perusahaan' => 'required|string|max:255',
        'lokasi_kerja' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'gaji' => 'nullable|integer|min:0',
    ]);

    Lowongan::create($request->all());

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Lowongan berhasil ditambahkan!']);
    }
    return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil ditambahkan!');
}

public function show(Lowongan $lowongan) {
    return view('lowongan.show', compact('lowongan'));
}

public function edit(Lowongan $lowongan) {
    return view('lowongan.edit', compact('lowongan'));
}

public function update(Request $request, Lowongan $lowongan) {
    $request->validate([
        'posisi' => 'required|string|max:255',
        'perusahaan' => 'required|string|max:255',
        'lokasi_kerja' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'gaji' => 'nullable|integer|min:0',
    ]);

    $lowongan->update($request->all());

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Lowongan berhasil diperbarui!']);
    }
    return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil diperbarui!');
}

public function destroy(Lowongan $lowongan) {
    $lowongan->delete();
    if (request()->ajax()) {
        return response()->json(['success' => true, 'message' => 'Lowongan berhasil dihapus!']);
    }
    return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil dihapus!');
}
```

**Step 3: LamaranController (User)**
Edit file `app/Http/Controllers/LamaranController.php`:

```php
// App/Http/Controllers/LamaranController.php
public function store(Request $request) {
    $request->validate([
        'lowongan_id' => 'required|exists:lowongans,id',
        'deskripsi_lamaran' => 'required|string',
        'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $cvPath = null;
    if ($request->hasFile('cv_file')) {
        $file = $request->file('cv_file');
        $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
        $cvPath = $file->storeAs('cv', $filename, 'public');
    }

    Lamaran::create([
        'user_id' => Auth::id(),
        'lowongan_id' => $request->lowongan_id,
        'deskripsi_lamaran' => $request->deskripsi_lamaran,
        'cv_file' => $cvPath,
    ]);

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Lamaran berhasil dikirim!']);
    }
    return redirect()->route('lamaran.index')->with('success', 'Lamaran berhasil dikirim!');
}

public function index() {
    if (Auth::user()->role === 'admin') {
        $lamarans = Lamaran::with(['user', 'lowongan'])->latest()->get();
    } else {
        $lamarans = Lamaran::with(['lowongan'])->where('user_id', Auth::id())->latest()->get();
    }
    return view('lamaran.index', compact('lamarans'));
}

public function downloadCV(Lamaran $lamaran) {
    if (Auth::user()->role !== 'admin' && $lamaran->user_id !== Auth::id()) {
        abort(403);
    }
    return Storage::disk('public')->download($lamaran->cv_file);
}
```

**Step 4: DashboardController**
Edit file `app/Http/Controllers/DashboardController.php`:

```php
// App/Http/Controllers/DashboardController.php
public function index() {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return $this->adminDashboard();
    }
    return $this->pelamarDashboard();
}

private function adminDashboard() {
    $totalLowongan = Lowongan::count();
    $totalLamaran = Lamaran::count();
    $totalPelamar = User::where('role', 'pelamar')->count();
    $recentLowongan = Lowongan::latest()->take(5)->get();
    $recentLamaran = Lamaran::with(['user', 'lowongan'])->latest()->take(5)->get();

    return view('dashboard.admin', compact('totalLowongan', 'totalLamaran', 'totalPelamar', 'recentLowongan', 'recentLamaran'));
}

private function pelamarDashboard() {
    $user = Auth::user();
    $totalLowongan = Lowongan::count();
    $myLamaran = Lamaran::where('user_id', $user->id)->count();
    $recentLowongan = Lowongan::latest()->take(5)->get();
    $myRecentLamaran = Lamaran::with('lowongan')->where('user_id', $user->id)->latest()->take(5)->get();

    return view('dashboard.pelamar', compact('totalLowongan', 'myLamaran', 'recentLowongan', 'myRecentLamaran'));
}
```

### 3.6 Implementasi Views (Antarmuka)

**Step 1: Layout Utama**
Buat file `resources/views/layouts/main.blade.php`:

```html
<!-- resources/views/layouts/main.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JobFinder')</title>
    <!-- CSS Dependencies -->
</head>
<body>
    <header class="main-header">
        <a href="{{ route('dashboard') }}" class="logo">JobFinder</a>
    </header>

    @include('partials.navbar')

    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2025 JobFinder Bandung</p>
    </footer>

    <!-- JS Dependencies -->
    @stack('scripts')
</body>
</html>
```

**Step 2: View Lowongan Index**
Buat file `resources/views/lowongan/index.blade.php`:

```html
<!-- resources/views/lowongan/index.blade.php -->
@extends('layouts.main')

@section('content')
<div class="page-header">
    <h1>Daftar Lowongan Pekerjaan</h1>
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('lowongan.create') }}" class="btn btn-primary">Tambah Lowongan</a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <table id="lowonganTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Posisi</th>
                    <th>Perusahaan</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#lowonganTable').DataTable({
        ajax: {
            url: '{{ route("lowongan.index") }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'posisi' },
            { data: 'perusahaan' },
            { data: 'lokasi_kerja' },
            {
                data: null,
                render: function(data, type, row) {
                    var html = '<a href="/lowongan/' + row.id + '" class="btn btn-sm btn-secondary">Detail</a>';
                    if ({{ Auth::user()->role === 'admin' ? 'true' : 'false' }}) {
                        html += '<a href="/lowongan/' + row.id + '/edit" class="btn btn-sm btn-warning">Edit</a>';
                    } else {
                        html += '<a href="/lamaran/create?lowongan=' + row.id + '" class="btn btn-sm btn-success">Lamar</a>';
                    }
                    return html;
                }
            }
        ]
    });
});
</script>
@endpush
```

**Step 3: View Tambah Lowongan**
Buat file `resources/views/lowongan/create.blade.php`:

```html
<!-- resources/views/lowongan/create.blade.php -->
@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Lowongan Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('lowongan.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Posisi</label>
                <input type="text" name="posisi" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Perusahaan</label>
                <input type="text" name="perusahaan" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Lokasi Kerja</label>
                <input type="text" name="lokasi_kerja" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Gaji</label>
                <input type="number" name="gaji" class="form-control">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
```

**Step 4: View Form Lamaran**
Buat file `resources/views/lamaran/create.blade.php`:

```html
<!-- resources/views/lamaran/create.blade.php -->
@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Form Lamaran</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('lamaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Pilih Lowongan</label>
                <select name="lowongan_id" class="form-control" required>
                    @foreach($lowongans as $lowongan)
                        <option value="{{ $lowongan->id }}">{{ $lowongan->posisi }} - {{ $lowongan->perusahaan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi Singkat</label>
                <textarea name="deskripsi_lamaran" class="form-control" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label>Upload CV (PDF/DOC)</label>
                <input type="file" name="cv_file" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Kirim Lamaran</button>
        </form>
    </div>
</div>
@endsection
```

**Step 5: View Dashboard Admin**
Buat file `resources/views/dashboard/admin.blade.php`:

```html
<!-- resources/views/dashboard/admin.blade.php -->
@extends('layouts.main')

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Admin</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $totalLowongan }}</h3>
        <p>Total Lowongan</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalLamaran }}</h3>
        <p>Total Lamaran</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalPelamar }}</h3>
        <p>Total Pelamar</p>
    </div>
</div>

<div class="recent-section">
    <h3>Lamaran Terbaru</h3>
    @foreach($recentLamaran as $lamaran)
        <div class="item">
            <strong>{{ $lamaran->user->name }}</strong> melamar 
            <strong>{{ $lamaran->lowongan->posisi }}</strong>
        </div>
    @endforeach
</div>
@endsection
```

### 3.7 Implementasi Routes

**Step 1: Routes Web**
Edit file `routes/web.php` untuk mengatur navigasi:

```php
// routes/web.php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LowonganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Lowongan - Public read, Admin write
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show');
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/lowongan-create', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
        Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update'])->name('lowongan.update');
        Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');
    });

    // Lamaran
    Route::get('/lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::get('/lamaran/create', [LamaranController::class, 'create'])->name('lamaran.create');
    Route::post('/lamaran', [LamaranController::class, 'store'])->name('lamaran.store');
    Route::get('/lamaran/{lamaran}/download-cv', [LamaranController::class, 'downloadCV'])->name('lamaran.download-cv');
});

require __DIR__.'/auth.php';
```

### 3.8 Implementasi API

**Step 1: Routes API**
Edit file `routes/api.php`:

```php
// routes/api.php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LamaranController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    
    // API Resources for Lamaran
    Route::apiResource('lamaran', LamaranController::class);
});
```

**Step 2: Controller API**
Edit file `app/Http/Controllers/Api/LamaranController.php`:

```php
// App/Http/Controllers/Api/LamaranController.php
public function index(Request $request) {
    if ($request->user()->role === 'admin') {
        $lamarans = Lamaran::with(['user', 'lowongan'])->latest()->get();
    } else {
        $lamarans = Lamaran::with(['lowongan'])->where('user_id', $request->user()->id)->latest()->get();
    }
    return response()->json(['success' => true, 'data' => $lamarans]);
}

public function store(Request $request) {
    $request->validate([
        'lowongan_id' => 'required|exists:lowongans,id',
        'deskripsi_lamaran' => 'required|string',
        'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $cvPath = $request->file('cv_file')->store('cv', 'public');

    $lamaran = Lamaran::create([
        'user_id' => $request->user()->id,
        'lowongan_id' => $request->lowongan_id,
        'deskripsi_lamaran' => $request->deskripsi_lamaran,
        'cv_file' => $cvPath,
    ]);

    return response()->json(['success' => true, 'data' => $lamaran], 201);
}
```

---

## BAB IV: PENGUJIAN SISTEM

### 4.1 Uji Coba Login dan Registrasi
Pengujian dilakukan untuk memastikan user dapat mendaftar dan login. Sistem akan membedakan redirect dashboard berdasarkan role. Default role saat registrasi adalah 'pelamar'.

*(Silakan lampirkan screenshot halaman login dan register di sini)*

### 4.2 Uji Coba Dashboard
Dashboard menampilkan statistik yang berbeda.
*   **Admin**: Melihat total pelamar, total lowongan, dan lamaran masuk.
*   **Pelamar**: Melihat status lamaran sendiri dan lowongan tersedia.

```html
<!-- resources/views/dashboard/admin.blade.php -->
@extends('layouts.main')

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Admin</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $totalLowongan }}</h3>
        <p>Total Lowongan</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalLamaran }}</h3>
        <p>Total Lamaran</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalPelamar }}</h3>
        <p>Total Pelamar</p>
    </div>
</div>

<div class="recent-section">
    <h3>Lamaran Terbaru</h3>
    @foreach($recentLamaran as $lamaran)
        <div class="item">
            <strong>{{ $lamaran->user->name }}</strong> melamar 
            <strong>{{ $lamaran->lowongan->posisi }}</strong>
        </div>
    @endforeach
</div>
@endsection
```

### 4.3 Uji Coba Manajemen Lowongan
Admin dapat menambah, mengedit, dan menghapus lowongan. Pengujian form dilakukan dengan memastikan validasi berjalan (misal: semua field wajib diisi).

*(Silakan lampirkan screenshot form tambah lowongan)*

### 4.4 Uji Coba Melamar Pekerjaan
Pelamar dapat memilih lowongan dan mengupload CV (PDF). Validasi file berjalan (maks 5MB). File yang diupload tersimpan di folder `storage/app/public/cv`.

---

## BAB V: ANALISIS DAN PENUTUP

### 5.1 Analisis Sistem
Aplikasi **JobFinder** dibangun dengan arsitektur **MVC (Model-View-Controller)** yang memisahkan logika bisnis, data, dan tampilan.
1.  **Keamanan**: Implementasi `RoleMiddleware` memastikan hanya user dengan hak akses yang tepat (Admin/Pelamar) yang bisa mengakses fitur tertentu. CSRF protection bawaan Laravel melindungi dari serangan cross-site.
2.  **Efisiensi Data**: Penggunaan Eloquent ORM dengan *Eager Loading* (`with(['user', 'lowongan'])`) pada Controller mengoptimalkan query database, mencegah masalah N+1 query problem saat mengambil data relasi.
3.  **User Experience (UX)**: Penggunaan Library **DataTables** memudahkan user mencari dan memfilter data lowongan tanpa reload halaman. **SweetAlert2** memberikan feedback interaktif (pop-up) yang lebih baik daripada alert browser standar.
4.  **Validasi**: Validasi di sisi server (`$request->validate`) mencegah data yang tidak valid (seperti file bukan PDF atau data kosong) masuk ke database, menjaga integritas data.

### 5.2 Kesimpulan
1.  Aplikasi berhasil memfasilitasi proses rekrutmen digital dengan fitur utama: Autentikasi Multi-Role, Manajemen Lowongan, dan Pelamaran Online.
2.  Fitur upload CV dan unduh CV berjalan dengan baik menggunakan sistem Storage Laravel.
3.  Implementasi REST API memungkinkan data lamaran diakses oleh platform lain (misalnya aplikasi mobile) di masa depan.
4.  Secara keseluruhan, sistem ini memenuhi kebutuhan dasar portal lowongan kerja yang efisien dan aman.

### 5.3 Saran
1.  Pengembangan fitur notifikasi email otomatis (menggunakan Laravel Mail) kepada pelamar saat status lamaran berubah.
2.  Penambahan fitur filter pencarian yang lebih kompleks (berdasarkan range gaji, lokasi spesifik).
3.  Implementasi unit testing (PHPUnit) yang lebih komprehensif untuk menjamin kualitas kode jangka panjang.

---

## DAFTAR PUSTAKA
1.  Laravel Documentation. (2025). *Installation & Configuration*.
2.  W3Schools. (2024). *PHP & MySQL Tutorial*.
3.  Refactoring UI. *Best Practices for Web Design*.
