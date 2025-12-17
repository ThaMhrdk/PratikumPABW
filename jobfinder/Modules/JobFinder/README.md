# JobFinder Module - API Documentation

## Base URL
```
/api/v1
```

## Authentication API

### Register
- **URL:** `/auth/register`
- **Method:** `POST`
- **Body:**
```json
{
    "name": "Nama Lengkap",
    "email": "email@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
- **Response:**
```json
{
    "success": true,
    "message": "Registrasi berhasil",
    "data": {
        "user": {...},
        "token": "Bearer token",
        "token_type": "Bearer"
    }
}
```

### Login
- **URL:** `/auth/login`
- **Method:** `POST`
- **Body:**
```json
{
    "email": "email@example.com",
    "password": "password123"
}
```
- **Response:**
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {...},
        "token": "Bearer token",
        "token_type": "Bearer"
    }
}
```

### Logout
- **URL:** `/auth/logout`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer {token}`
- **Response:**
```json
{
    "success": true,
    "message": "Logout berhasil"
}
```

### Get Profile
- **URL:** `/auth/profile`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`

---

## Lamaran API

### Get All Lamaran
- **URL:** `/lamaran`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`
- **Note:** Admin melihat semua lamaran, Pelamar hanya melihat lamarannya sendiri

### Create Lamaran
- **URL:** `/lamaran`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer {token}`
- **Body (form-data):**
  - `lowongan_id`: ID lowongan
  - `deskripsi_lamaran`: Deskripsi lamaran
  - `cv_file`: File CV (PDF/DOC/DOCX)

### Get Lamaran Detail
- **URL:** `/lamaran/{id}`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`

### Update Lamaran
- **URL:** `/lamaran/{id}`
- **Method:** `POST`
- **Headers:** `Authorization: Bearer {token}`
- **Body (form-data):**
  - `deskripsi_lamaran`: Deskripsi lamaran
  - `cv_file`: File CV baru (opsional)
  - `status`: Status (admin only: pending/diterima/ditolak)

### Delete Lamaran
- **URL:** `/lamaran/{id}`
- **Method:** `DELETE`
- **Headers:** `Authorization: Bearer {token}`

### Download CV
- **URL:** `/lamaran/{id}/download-cv`
- **Method:** `GET`
- **Headers:** `Authorization: Bearer {token}`

---

## Akun Default

### Admin
- **Email:** admin@jobfinder.com
- **Password:** password123

### Pelamar
- **Email:** pelamar@jobfinder.com
- **Password:** password123
