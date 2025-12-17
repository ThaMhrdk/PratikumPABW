# JobFinder - Portal Lowongan Kerja Kabupaten Bandung

Platform portal lowongan kerja yang menghubungkan pencari kerja dengan perusahaan lokal di Kabupaten Bandung.

## Fitur Utama

- **Autentikasi dengan Role Management** (Admin & Pelamar)
- **CRUD Lowongan Pekerjaan** (Admin Only)
- **CRUD Lamaran dengan Upload CV** (Admin & Pelamar)
- **RESTful API** untuk Autentikasi dan CRUD Lamaran
- **HMVC Architecture** menggunakan Laravel Modules
- **AJAX/Asynchronous** untuk operasi CRUD

## Teknologi

- Laravel 11.x
- Laravel Modules (nwidart/laravel-modules)
- Laravel Sanctum (API Authentication)
- Bootstrap 5
- jQuery
- MySQL

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd jobfinder
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database
Buat database MySQL dengan nama `jobfinder`, lalu sesuaikan file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobfinder
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migrasi dan Seeder
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 6. Jalankan Server
```bash
php artisan serve
```

## Akun Default

### Admin
- **Email:** admin@jobfinder.com
- **Password:** password123

### Pelamar
- **Email:** pelamar@jobfinder.com
- **Password:** password123

## Struktur Module

```
Modules/JobFinder/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthApiController.php
│   │   │   │   └── LamaranApiController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LamaranController.php
│   │   │   └── LowonganController.php
│   │   └── Middleware/
│   │       ├── CekAdmin.php
│   │       └── CekPelamar.php
│   ├── Models/
│   │   ├── Lamaran.php
│   │   └── Lowongan.php
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── dashboard/
│   ├── lamaran/
│   ├── lowongan/
│   ├── layouts/
│   └── partials/
└── routes/
    ├── api.php
    └── web.php
```

## API Endpoints

### Autentikasi
- `POST /api/v1/auth/register` - Registrasi user baru
- `POST /api/v1/auth/login` - Login user
- `POST /api/v1/auth/logout` - Logout user (requires token)
- `GET /api/v1/auth/profile` - Get user profile (requires token)

### Lamaran
- `GET /api/v1/lamaran` - List semua lamaran
- `POST /api/v1/lamaran` - Buat lamaran baru dengan upload CV
- `GET /api/v1/lamaran/{id}` - Detail lamaran
- `POST /api/v1/lamaran/{id}` - Update lamaran
- `DELETE /api/v1/lamaran/{id}` - Hapus lamaran
- `GET /api/v1/lamaran/{id}/download-cv` - Download CV

## Role & Permission

### Admin
- Akses dashboard admin
- CRUD lengkap lowongan pekerjaan
- Melihat semua lamaran
- Update status lamaran (pending/diterima/ditolak)
- Hapus lamaran

### Pelamar
- Akses dashboard pelamar
- Melihat daftar lowongan
- Melamar pekerjaan dengan upload CV
- Melihat & mengedit lamaran sendiri
- Download CV sendiri

## License

MIT License - © 2025 JobFinder Bandung
