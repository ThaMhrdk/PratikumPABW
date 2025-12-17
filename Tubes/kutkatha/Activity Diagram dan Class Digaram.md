# KUTKATHA - Dokumentasi Sistem
## Platform Layanan Psikologi Digital Kutai Kartanegara

---

## 1. ACTIVITY DIAGRAM

### 1.1 Activity Diagram: User Melakukan Booking Konsultasi

```
START
  |
  v
[User Login]
  |
  v
{Berhasil?} --NO--> [Tampilkan Error]
  |                        |
  YES                      v
  |                    [Kembali ke Login]
  |                        |
  |<-----------------------
  |
  v
[Lihat Daftar Psikolog]
  |
  v
[Filter Psikolog] (Spesialisasi, Lokasi, Rating)
  |
  v
[Pilih Psikolog]
  |
  v
[Lihat Jadwal Tersedia]
  |
  v
{Ada Jadwal?} --NO--> [Tampilkan "Jadwal Penuh"]
  |                           |
  YES                         v
  |                       [Kembali ke Daftar Psikolog]
  |                           |
  |<--------------------------
  |
  v
[Pilih Jadwal & Isi Keluhan]
  |
  v
[Buat Booking]
  |
  v
[Sistem Generate Booking Code]
  |
  v
[Proses Pembayaran]
  |
  v
{Metode Pembayaran} --> [Transfer/E-Wallet/Tunai]
  |
  v
[Upload Bukti Pembayaran]
  |
  v
{Verifikasi Pembayaran} --FAILED--> [Transaksi Gagal]
  |                                      |
  SUCCESS                                v
  |                              [Tampilkan Error]
  |                                      |
  |<------------------------------------|
  |
  v
[Booking Confirmed]
  |
  v
[Kirim Notifikasi ke Psikolog]
  |
  v
[Tampilkan Booking Detail]
  |
  v
END
```

### 1.2 Activity Diagram: Psikolog Melakukan Konsultasi

```
START
  |
  v
[Psikolog Login]
  |
  v
{Berhasil?} --NO--> [Tampilkan Error]
  |                      |
  YES                    v
  |                  [Kembali ke Login]
  |                      |
  |<---------------------
  |
  v
[Lihat Dashboard]
  |
  v
[View Booking Pending]
  |
  v
{Ada Booking?} --NO--> [Tidak Ada Konsultasi]
  |                          |
  YES                        v
  |                      END
  |
  v
[Pilih Booking untuk Dikonfirmasi]
  |
  v
[Konfirmasi Booking]
  |
  v
[Tunggu Waktu Konsultasi]
  |
  v
[Saat Jadwal: Mulai Konsultasi]
  |
  v
[Chat/Video Call dengan User]
  |
  v
[Input Catatan Konsultasi]
  |
  v
[Input Diagnosis & Rekomendasi]
  |
  v
[Set Jadwal Follow-up (jika perlu)]
  |
  v
[Selesaikan Konsultasi]
  |
  v
[Tampilkan Feedback Form untuk User]
  |
  v
END
```

### 1.3 Activity Diagram: Admin Memverifikasi Psikolog

```
START
  |
  v
[Admin Login]
  |
  v
[Akses Dashboard Admin]
  |
  v
[View Pending Psikolog Applications]
  |
  v
{Ada Pending?} --NO--> [Tidak Ada Aplikasi]
  |                         |
  YES                       v
  |                     END
  |
  v
[Pilih Aplikasi Psikolog]
  |
  v
[Review Data Psikolog]
  |  - Identitas
  |  - STR/Kredensial
  |  - Sertifikat
  |  - Riwayat Pendidikan
  |
  v
[Cek Dokumen Valid?]
  |
  +-- TIDAK VALID --> [Reject Aplikasi]
  |                       |
  |                       v
  |                  [Kirim Notif Penolakan]
  |                       |
  |                       v
  |                  END
  |
  +-- VALID --> [Approve Aplikasi]
                     |
                     v
                [Update Status: VERIFIED]
                     |
                     v
                [Psikolog Bisa Aktif]
                     |
                     v
                [Kirim Email Verifikasi]
                     |
                     v
                END
```

### 1.4 Activity Diagram: Pemerintah Membuat Laporan

```
START
  |
  v
[Pemerintah Login]
  |
  v
[Akses Dashboard Pemerintah]
  |
  v
[Pilih Menu Reports]
  |
  v
[Input Periode Laporan] (Mulai - Selesai)
  |
  v
[Pilih Tipe Laporan]
  |  - Monthly (Bulanan)
  |  - Quarterly (Triwulan)
  |  - Annual (Tahunan)
  |
  v
[Sistem Generate Data]
  |  - Total Konsultasi
  |  - Total User
  |  - Total Psikolog
  |  - Statistik Detail
  |
  v
[Preview Laporan]
  |
  v
[Edit Summary (Optional)]
  |
  v
{Setuju?} --NO--> [Edit Lagi]
  |               |
  YES             |
  |<--------------
  |
  v
[Simpan Laporan]
  |
  v
[Download PDF/Excel]
  |
  v
[Send Report]
  |
  v
[Laporan Dikirim ke Instansi]
  |
  v
END
```

### 1.5 Activity Diagram: User Posting di Forum

```
START
  |
  v
[User Login]
  |
  v
[Akses Forum]
  |
  v
[Lihat Daftar Topik]
  |
  v
{Buat Topik Baru?} --YA--> [Input Judul & Kategori]
  |                                |
  TIDAK                            v
  |                          [Input Deskripsi Masalah]
  |                                |
  |                                v
  |                          [Pilih: Anonim/Identitas]
  |                                |
  |                                v
  |                          [Create Topic]
  |                                |
  |                                v
  |<------ [Notif ke Psikolog] ----
  |
  v
[Lihat Topik yang Ada]
  |
  v
[Pilih Topik untuk Dibaca]
  |
  v
[Lihat Postingan & Komentar]
  |
  v
{Ingin Komentar?} --NO--> [End]
  |
  YES
  |
  v
[Tulis Komentar]
  |
  v
[Preview Komentar]
  |
  v
[Post Komentar]
  |
  v
[Notifikasi ke Author Postingan]
  |
  v
[Tampilkan Komentar]
  |
  v
END
```

---

## 2. MVC ARCHITECTURE DIAGRAM

```
┌─────────────────────────────────────────────────────────────────┐
│                    KUTKATHA MVC ARCHITECTURE                     │
└─────────────────────────────────────────────────────────────────┘

┌────────────────────────────────────────────────────────────────┐
│                          VIEW LAYER                             │
├────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────────────┐  ┌─────────────────┐  ┌──────────────┐  │
│  │  Welcome Pages  │  │  Auth Templates │  │  User Pages  │  │
│  └─────────────────┘  └─────────────────┘  └──────────────┘  │
│         |                    |                     |            │
│  ┌─────────────────┐  ┌─────────────────┐  ┌──────────────┐  │
│  │  Dashboard      │  │  Booking Pages  │  │  Forum Pages │  │
│  └─────────────────┘  └─────────────────┘  └──────────────┘  │
│         |                    |                     |            │
│  ┌─────────────────┐  ┌─────────────────┐  ┌──────────────┐  │
│  │  Admin Panel    │  │  Psikolog Pages │  │ Articles     │  │
│  └─────────────────┘  └─────────────────┘  └──────────────┘  │
│         |                    |                     |            │
│                    (Blade Templates)                            │
│                    (Bootstrap 5 CSS)                            │
│                    (Alpine.js Interactive)                      │
│                                                                 │
└────────────────────────────────────────────────────────────────┘
                              ↓ HTTP
┌────────────────────────────────────────────────────────────────┐
│                      CONTROLLER LAYER                           │
├────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────┐  ┌──────────────────────┐            │
│  │ AuthController       │  │ UserController       │            │
│  │ - login()            │  │ - index()            │            │
│  │ - logout()           │  │ - show()             │            │
│  │ - register()         │  │ - profile()          │            │
│  └──────────────────────┘  └──────────────────────┘            │
│                                                                 │
│  ┌──────────────────────┐  ┌──────────────────────┐            │
│  │ BookingController    │  │ PsikologController   │            │
│  │ - index()            │  │ - index()            │            │
│  │ - create()           │  │ - show()             │            │
│  │ - store()            │  │ - verify()           │            │
│  │ - cancel()           │  │ - updateProfile()    │            │
│  └──────────────────────┘  └──────────────────────┘            │
│                                                                 │
│  ┌──────────────────────┐  ┌──────────────────────┐            │
│  │ ForumController      │  │ ArticleController    │            │
│  │ - index()            │  │ - index()            │            │
│  │ - createTopic()      │  │ - show()             │            │
│  │ - storeTopic()       │  │ - publish()          │            │
│  │ - postComment()      │  │ - draft()            │            │
│  └──────────────────────┘  └──────────────────────┘            │
│                                                                 │
│  ┌──────────────────────┐  ┌──────────────────────┐            │
│  │ AdminController      │  │ PaymentController    │            │
│  │ - dashboard()        │  │ - process()          │            │
│  │ - verifyPsikolog()   │  │ - verify()           │            │
│  │ - rejectPsikolog()   │  │ - history()          │            │
│  └──────────────────────┘  └──────────────────────┘            │
│                                                                 │
│  ┌──────────────────────────────────────────────┐              │
│  │ ReportController                             │              │
│  │ - index()                                    │              │
│  │ - generate()                                 │              │
│  │ - export()                                   │              │
│  └──────────────────────────────────────────────┘              │
│                                                                 │
└────────────────────────────────────────────────────────────────┘
                    ↓ Query & Data Processing
┌────────────────────────────────────────────────────────────────┐
│                       MODEL LAYER                               │
├────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │ User Model   │  │ Psikolog     │  │ Schedule     │          │
│  │              │  │ Model        │  │ Model        │          │
│  │ - Table:     │  │              │  │              │          │
│  │   users      │  │ - Table:     │  │ - Table:     │          │
│  │              │  │   psikologs  │  │   schedules  │          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
│                                                                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │ Booking      │  │ Payment      │  │ Consultation │          │
│  │ Model        │  │ Model        │  │ Model        │          │
│  │              │  │              │  │              │          │
│  │ - Table:     │  │ - Table:     │  │ - Table:     │          │
│  │   bookings   │  │   payments   │  │ consultations│          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
│                                                                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐          │
│  │ Feedback     │  │ ForumTopic   │  │ ForumPost    │          │
│  │ Model        │  │ Model        │  │ Model        │          │
│  │              │  │              │  │              │          │
│  │ - Table:     │  │ - Table:     │  │ - Table:     │          │
│  │   feedbacks  │  │   forum_     │  │   forum_     │          │
│  │              │  │   topics     │  │   posts      │          │
│  └──────────────┘  └──────────────┘  └──────────────┘          │
│                                                                 │
│  ┌──────────────────────────────────────────────┐              │
│  │ Article, ForumComment, ChatMessage, Report   │              │
│  │ Models (Database Tables)                     │              │
│  └──────────────────────────────────────────────┘              │
│                                                                 │
└────────────────────────────────────────────────────────────────┘
                              ↓
┌────────────────────────────────────────────────────────────────┐
│                     DATABASE LAYER (MySQL)                      │
├────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │ kutkatha Database                                       │   │
│  │ - 13 Tabel Relasional                                  │   │
│  │ - Foreign Key Constraints                              │   │
│  │ - Indexed untuk Performance                            │   │
│  └─────────────────────────────────────────────────────────┘   │
│                                                                 │
└────────────────────────────────────────────────────────────────┘

┌────────────────────────────────────────────────────────────────┐
│                   AUXILIARY COMPONENTS                          │
├────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Middleware:                                                   │
│  - Auth Middleware (Authentikasi)                              │
│  - Role Middleware (Otorisasi berbasis Role)                   │
│  - TrustProxies, ThrottleRequests, dll                         │
│                                                                 │
│  Services & Business Logic:                                    │
│  - PaymentService (Proses Pembayaran)                          │
│  - NotificationService (Email/SMS)                             │
│  - ReportService (Generate Laporan)                            │
│                                                                 │
│  Helpers & Utilities:                                          │
│  - Helper Functions                                            │
│  - Validation Rules                                            │
│                                                                 │
└────────────────────────────────────────────────────────────────┘
```

---

## 3. CLASS DIAGRAM

```
┌──────────────────────────────────────────────────────────────────┐
│                      USER MANAGEMENT                              │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────────────────┐
│         User                │
├─────────────────────────────┤
│ - id: bigint                │
│ - name: string              │
│ - email: string (unique)    │
│ - password: string          │
│ - role: enum                │
│   (user|psikolog|admin|     │
│    pemerintah)              │
│ - phone: string             │
│ - address: text             │
│ - photo: string             │
│ - is_active: boolean        │
│ - created_at: timestamp     │
│ - updated_at: timestamp     │
├─────────────────────────────┤
│ + isUser(): bool            │
│ + isPsikolog(): bool        │
│ + isAdmin(): bool           │
│ + isPemerintah(): bool      │
│ + getPhotoUrl(): string     │
│ + psikolog() → Psikolog     │
│ + bookings() → Booking[]    │
│ + forums() → ForumTopic[]   │
│ + articles() → Article[]    │
└─────────────────────────────┘
         △
         │ extends
         │
  (Authenticatable)

┌──────────────────────────────────────────────────────────────────┐
│                   KONSULTASI MANAGEMENT                           │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────────────────┐         ┌─────────────────────────┐
│      Psikolog               │         │      Schedule           │
├─────────────────────────────┤         ├─────────────────────────┤
│ - id: bigint                │         │ - id: bigint            │
│ - user_id: FK→User          │         │ - psikolog_id: FK→Psik. │
│ - str_number: string        │         │ - date: date            │
│ - specialization: string    │         │ - start_time: time      │
│ - bio: text                 │         │ - end_time: time        │
│ - education: text           │         │ - consultation_type:    │
│ - certifications: text      │         │   enum(online|offline|  │
│ - experience_years: int     │         │   chat)                 │
│ - consultation_fee: decimal │         │ - is_available: bool    │
│ - verification_status:      │         │ - location: string      │
│   enum(pending|verified|    │         │ - created_at: timestamp │
│   rejected)                 │         │ - updated_at: timestamp │
│ - verified_at: timestamp    │         ├─────────────────────────┤
│ - average_rating: decimal   │         │ + getFormattedTime()    │
│ - total_reviews: int        │         │ + getTypeLabel()        │
│ - created_at: timestamp     │         │ + isBooked(): bool      │
├─────────────────────────────┤         │ + psikolog() → Psikolog │
│ + isVerified(): bool        │         │ + bookings() → Booking[]│
│ + isPending(): bool         │         └─────────────────────────┘
│ + getAverageRating()        │                △
│ + user() → User             │                │ 1:N
│ + schedules() → Schedule[]  │                │
└─────────────────────────────┘                │
         △                                     │
         │ 1:1                                 │
         │ N:1                                 │
         └─────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────┐

┌─────────────────────────────┐         ┌─────────────────────────┐
│       Booking               │         │      Payment            │
├─────────────────────────────┤         ├─────────────────────────┤
│ - id: bigint                │         │ - id: bigint            │
│ - user_id: FK→User          │         │ - booking_id: FK→Booking│
│ - schedule_id: FK→Schedule  │         │ - payment_code: string  │
│ - booking_code: string      │         │ - amount: decimal       │
│ - status: enum(pending|     │         │ - payment_method:       │
│   confirmed|completed|      │         │   enum(transfer|ewallet │
│   cancelled|rescheduled)    │         │   |cash)                │
│ - complaint: text           │         │ - status: enum(pending| │
│ - notes: text               │         │   paid|failed|refunded) │
│ - confirmed_at: timestamp   │         │ - proof_of_payment:     │
│ - cancelled_at: timestamp   │         │   string                │
│ - cancel_reason: text       │         │ - paid_at: timestamp    │
│ - created_at: timestamp     │         │ - created_at: timestamp │
├─────────────────────────────┤         ├─────────────────────────┤
│ + getStatusBadge(): HTML    │         │ + getStatusBadge()      │
│ + isPaid(): bool            │         │ + getFormattedAmount()  │
│ + canBeCancelled(): bool    │         │ + getMethodName()       │
│ + user() → User             │         │ + booking() → Booking   │
│ + schedule() → Schedule     │         └─────────────────────────┘
│ + payment() → Payment       │                △
│ + consultation() →          │                │ 1:1
│   Consultation              │                │
└─────────────────────────────┘                │
         △                                     │
         │ 1:1                                 │
         │ N:1                                 │
         └─────────────────────────────────────┘

┌─────────────────────────────┐
│     Consultation            │
├─────────────────────────────┤
│ - id: bigint                │
│ - booking_id: FK→Booking    │
│ - summary: text             │
│ - diagnosis: text           │
│ - recommendation: text      │
│ - follow_up_notes: text     │
│ - next_session_date: date   │
│ - status: enum(ongoing|     │
│   completed)                │
│ - started_at: timestamp     │
│ - ended_at: timestamp       │
│ - created_at: timestamp     │
├─────────────────────────────┤
│ + isCompleted(): bool       │
│ + getDuration(): string     │
│ + booking() → Booking       │
│ + feedback() → Feedback     │
│ + chatMessages() →          │
│   ChatMessage[]             │
└─────────────────────────────┘
         △
         │ 1:1
         │
    Booking

┌─────────────────────────────┐         ┌─────────────────────────┐
│      Feedback               │         │   ChatMessage           │
├─────────────────────────────┤         ├─────────────────────────┤
│ - id: bigint                │         │ - id: bigint            │
│ - consultation_id: FK       │         │ - consultation_id: FK   │
│ - user_id: FK→User          │         │ - sender_id: FK→User    │
│ - rating: int (1-5)         │         │ - message: text         │
│ - comment: text             │         │ - attachment: string    │
│ - is_anonymous: boolean     │         │ - is_read: boolean      │
│ - created_at: timestamp     │         │ - read_at: timestamp    │
├─────────────────────────────┤         │ - created_at: timestamp │
│ + getStarsHtml(): HTML      │         ├─────────────────────────┤
│ + consultation() →          │         │ + markAsRead()          │
│   Consultation              │         │ + getAttachmentUrl()    │
│ + user() → User             │         │ + consultation() →      │
└─────────────────────────────┘         │   Consultation          │
                                        │ + sender() → User       │
                                        └─────────────────────────┘

┌──────────────────────────────────────────────────────────────────┐
│                    FORUM MANAGEMENT                               │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────────────────┐         ┌─────────────────────────┐
│     ForumTopic              │         │     ForumPost           │
├─────────────────────────────┤         ├─────────────────────────┤
│ - id: bigint                │         │ - id: bigint            │
│ - user_id: FK→User          │         │ - topic_id: FK→Topic    │
│ - title: string             │         │ - user_id: FK→User      │
│ - slug: string (unique)     │         │ - content: text         │
│ - category: string          │         │ - is_anonymous: bool    │
│ - description: text         │         │ - is_best_answer: bool  │
│ - is_anonymous: boolean     │         │ - created_at: timestamp │
│ - is_pinned: boolean        │         │ - updated_at: timestamp │
│ - is_closed: boolean        │         ├─────────────────────────┤
│ - views_count: int          │         │ + getAuthorName()       │
│ - created_at: timestamp     │         │ + incrementViews()      │
├─────────────────────────────┤         │ + topic() → ForumTopic  │
│ + getPostsCount(): int      │         │ + user() → User         │
│ + getAuthorName(): string   │         │ + comments() →          │
│ + user() → User             │         │   ForumComment[]        │
│ + posts() → ForumPost[]     │         └─────────────────────────┘
└─────────────────────────────┘                △
         △                                     │ 1:N
         │ 1:N                                 │
         │                                     │
         └─────────────────────────────────────┘

┌─────────────────────────────┐
│    ForumComment             │
├─────────────────────────────┤
│ - id: bigint                │
│ - post_id: FK→ForumPost     │
│ - user_id: FK→User          │
│ - parent_id: FK (nullable)  │
│ - content: text             │
│ - is_anonymous: boolean     │
│ - is_psikolog_answer: bool  │
│ - created_at: timestamp     │
├─────────────────────────────┤
│ + getAuthorName(): string   │
│ + post() → ForumPost        │
│ + user() → User             │
│ + parent() → ForumComment   │
│ + replies() →               │
│   ForumComment[]            │
└─────────────────────────────┘

┌──────────────────────────────────────────────────────────────────┐
│                   CONTENT MANAGEMENT                              │
└──────────────────────────────────────────────────────────────────┘

┌─────────────────────────────┐         ┌─────────────────────────┐
│      Article                │         │      Report             │
├─────────────────────────────┤         ├─────────────────────────┤
│ - id: bigint                │         │ - id: bigint            │
│ - author_id: FK→User        │         │ - created_by: FK→User   │
│ - title: string             │         │ - title: string         │
│ - slug: string (unique)     │         │ - report_type: string   │
│ - excerpt: text             │         │   (monthly|quarterly|   │
│ - content: longtext         │         │    annual)              │
│ - featured_image: string    │         │ - period_start: date    │
│ - category: string          │         │ - period_end: date      │
│ - status: enum(draft|       │         │ - total_consultations:  │
│   published)                │         │   int                   │
│ - views_count: int          │         │ - total_users: int      │
│ - published_at: timestamp   │         │ - total_psikologs: int  │
│ - created_at: timestamp     │         │ - statistics: json      │
├─────────────────────────────┤         │ - summary: text         │
│ + getImageUrl(): string     │         │ - status: enum(draft|   │
│ + incrementViews()          │         │   sent)                 │
│ + publish()                 │         │ - sent_at: timestamp    │
│ + author() → User           │         │ - created_at: timestamp │
│ + scopePublished()          │         ├─────────────────────────┤
│                             │         │ + getTypeLabel()        │
│                             │         │ + isSent(): bool        │
│                             │         │ + creator() → User      │
└─────────────────────────────┘         └─────────────────────────┘
```

---

## 4. ROLE & PERMISSION MATRIX

```
┌─────────────────────────────────────────────────────────────────┐
│              ROLE-BASED ACCESS CONTROL (RBAC)                   │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ ROLE: USER (Pengguna Biasa)                                      │
├─────────────────────────────────────────────────────────────────┤
│ Fitur yang Dapat Diakses:                                        │
│ ✓ View Daftar Psikolog                                           │
│ ✓ Filter Psikolog berdasarkan Spesialisasi, Rating              │
│ ✓ Booking Konsultasi                                             │
│ ✓ Proses Pembayaran                                              │
│ ✓ View History Booking & Konsultasi                              │
│ ✓ Memberikan Feedback/Rating                                     │
│ ✓ Chat dengan Psikolog saat Konsultasi                           │
│ ✓ View Artikel Edukatif                                          │
│ ✓ Post di Forum (Topik/Komentar)                                 │
│ ✓ View Profile Pribadi                                           │
│ ✓ Edit Profile Pribadi                                           │
│                                                                  │
│ Fitur yang TIDAK Dapat Diakses:                                  │
│ ✗ Approve/Reject Psikolog                                        │
│ ✗ Buat Artikel                                                   │
│ ✗ Lihat Laporan                                                  │
│ ✗ Admin Dashboard                                                │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ ROLE: PSIKOLOG (Professional)                                    │
├─────────────────────────────────────────────────────────────────┤
│ Fitur yang Dapat Diakses:                                        │
│ ✓ View Profile Pribadi (dengan STR, Sertifikasi)                 │
│ ✓ Edit Profile & Jadwal Konsultasi                               │
│ ✓ View Booking Pending                                           │
│ ✓ Konfirmasi/Reject Booking                                      │
│ ✓ Chat dengan User saat Konsultasi                               │
│ ✓ Input Catatan Konsultasi (Diagnosis, Rekomendasi)              │
│ ✓ View Feedback dari User                                        │
│ ✓ Post Komentar di Forum (sebagai Expert)                        │
│ ✓ Lihat Statistik Konsultasi Pribadi                             │
│ ✓ Lihat Rating & Review                                          │
│                                                                  │
│ Fitur yang TIDAK Dapat Diakses:                                  │
│ ✗ Approve/Reject Psikolog Lain                                   │
│ ✗ Lihat Data User Lain                                           │
│ ✗ Buat Laporan                                                   │
│ ✗ Admin Dashboard                                                │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ ROLE: ADMIN (Administrator)                                      │
├─────────────────────────────────────────────────────────────────┤
│ Fitur yang Dapat Diakses:                                        │
│ ✓ Dashboard Admin (Statistik Sistem)                             │
│ ✓ View Pending Psikolog Applications                             │
│ ✓ Review & Approve Psikolog                                      │
│ ✓ Reject Psikolog (dengan Alasan)                                │
│ ✓ View All Users                                                 │
│ ✓ Suspend/Activate User                                          │
│ ✓ Manage Forum (Edit/Delete Topik & Postingan Jika Melanggar)    │
│ ✓ Moderate Konten (Forum, Artikel Tidak Sesuai)                  │
│ ✓ View System Logs                                               │
│ ✓ Generate Statistik                                             │
│                                                                  │
│ Fitur yang TIDAK Dapat Diakses:                                  │
│ ✗ Buat Laporan ke Pemerintah (hanya Pemerintah)                  │
│ ✗ Chat dengan User                                               │
│ ✗ Booking Konsultasi                                             │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ ROLE: PEMERINTAH (Government Official)                            │
├─────────────────────────────────────────────────────────────────┤
│ Fitur yang Dapat Diakses:                                        │
│ ✓ Dashboard Pemerintah                                           │
│ ✓ View Statistik Konsultasi (Periode Tertentu)                   │
│ ✓ Generate Laporan (Monthly, Quarterly, Annual)                  │
│ ✓ Export Laporan (PDF, Excel)                                    │
│ ✓ View Demografi User & Psikolog                                 │
│ ✓ View Trending Topics di Forum                                  │
│ ✓ Download Data Statistik                                        │
│                                                                  │
│ Fitur yang TIDAK Dapat Diakses:                                  │
│ ✗ Approve Psikolog                                               │
│ ✗ Lihat Data Detail User Individual                              │
│ ✗ Chat                                                           │
│ ✗ Booking Konsultasi                                             │
│ ✗ Admin Dashboard                                                │
└─────────────────────────────────────────────────────────────────┘
```

---

## 5. FILE STRUCTURE

```
kutkatha/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── UserController.php
│   │   │   ├── PsikologController.php
│   │   │   ├── BookingController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── ConsultationController.php
│   │   │   ├── FeedbackController.php
│   │   │   ├── ForumController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── ReportController.php
│   │   │   ├── ChatController.php
│   │   │   ├── AdminController.php
│   │   │   └── DashboardController.php
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       ├── RoleMiddleware.php
│   │       └── AuthenticateSession.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Psikolog.php
│   │   ├── Schedule.php
│   │   ├── Booking.php
│   │   ├── Payment.php
│   │   ├── Consultation.php
│   │   ├── Feedback.php
│   │   ├── ForumTopic.php
│   │   ├── ForumPost.php
│   │   ├── ForumComment.php
│   │   ├── Article.php
│   │   ├── Report.php
│   │   └── ChatMessage.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Services/
│       ├── PaymentService.php
│       ├── NotificationService.php
│       └── ReportService.php
├── database/
│   ├── migrations/
│   │   └── [15 migration files]
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── auth/
│   │   ├── user/
│   │   ├── psikolog/
│   │   ├── admin/
│   │   ├── pemerintah/
│   │   ├── forum/
│   │   ├── booking/
│   │   └── components/
│   ├── css/
│   │   └── app.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── routes/
│   └── web.php
├── public/
│   ├── index.php
│   └── [assets]
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── [other config]
└── storage/
    ├── app/
    ├── framework/
    └── logs/
```

---

## KESIMPULAN

Kutkatha adalah platform full-stack Laravel yang mengimplementasikan:

1. **MVC Architecture** - Pemisahan concerns antara View, Controller, dan Model
2. **Role-Based Access Control** - 4 role berbeda dengan permission yang spesifik
3. **RESTful API Pattern** - Melalui routing yang jelas
4. **Database Normalization** - 13 tabel dengan relasi yang tepat
5. **Activity Flows** - Proses bisnis yang terdokumentasi dengan baik
6. **Security Best Practices** - Authentication, Authorization, Input Validation

Sistem ini siap untuk production dengan proper structure, scalability, dan maintainability.
