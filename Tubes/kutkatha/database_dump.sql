-- =============================================================================
-- KUTKATHA DATABASE DUMP
-- Generated: 2025-12-16
-- Database: kutkatha
-- =============================================================================

-- Struktur Tabel: users (pengguna)
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','psikolog','admin','pemerintah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci,
  `is_active` boolean DEFAULT true,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: psikologs (Daftar Psikolog)
CREATE TABLE IF NOT EXISTS `psikologs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `str_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE COMMENT 'Nomor STR Psikolog',
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `education` text COLLATE utf8mb4_unicode_ci,
  `certifications` text COLLATE utf8mb4_unicode_ci,
  `experience_years` int DEFAULT 0,
  `consultation_fee` decimal(12,2) DEFAULT 0,
  `verification_status` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `verified_at` timestamp NULL DEFAULT NULL,
  `str_document` varchar(255) COLLATE utf8mb4_unicode_ci,
  `certificate_document` varchar(255) COLLATE utf8mb4_unicode_ci,
  `average_rating` decimal(3,2) DEFAULT 0,
  `total_reviews` int DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `psikologs_str_number_unique` (`str_number`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: schedules (Jadwal Konsultasi)
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `psikolog_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `consultation_type` enum('online','offline','chat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` boolean DEFAULT true,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci COMMENT 'Untuk offline consultation',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`psikolog_id`) REFERENCES `psikologs`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: bookings (Pemesanan Konsultasi)
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `schedule_id` bigint unsigned NOT NULL,
  `booking_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `status` enum('pending','confirmed','completed','cancelled','rescheduled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `complaint` text COLLATE utf8mb4_unicode_ci COMMENT 'Keluhan user',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_booking_code_unique` (`booking_code`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`schedule_id`) REFERENCES `schedules`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: payments (Pembayaran)
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `payment_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` enum('transfer','ewallet','cash') COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','paid','failed','refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `proof_of_payment` varchar(255) COLLATE utf8mb4_unicode_ci,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_code_unique` (`payment_code`),
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: consultations (Konsultasi)
CREATE TABLE IF NOT EXISTS `consultations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci COMMENT 'Ringkasan konsultasi',
  `diagnosis` text COLLATE utf8mb4_unicode_ci,
  `recommendation` text COLLATE utf8mb4_unicode_ci,
  `follow_up_notes` text COLLATE utf8mb4_unicode_ci,
  `next_session_date` date,
  `status` enum('ongoing','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'ongoing',
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: feedbacks (Umpan Balik/Review)
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `consultation_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` int NOT NULL COMMENT '1-5 stars',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `is_anonymous` boolean DEFAULT false,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`consultation_id`) REFERENCES `consultations`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: forum_topics (Topik Forum)
CREATE TABLE IF NOT EXISTS `forum_topics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci UNIQUE,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_anonymous` boolean DEFAULT false,
  `is_pinned` boolean DEFAULT false,
  `is_closed` boolean DEFAULT false,
  `views_count` int DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forum_topics_slug_unique` (`slug`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: forum_posts (Postingan Forum)
CREATE TABLE IF NOT EXISTS `forum_posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_anonymous` boolean DEFAULT false,
  `is_best_answer` boolean DEFAULT false,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`topic_id`) REFERENCES `forum_topics`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: forum_comments (Komentar Forum)
CREATE TABLE IF NOT EXISTS `forum_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_anonymous` boolean DEFAULT false,
  `is_psikolog_answer` boolean DEFAULT false,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `forum_posts`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`parent_id`) REFERENCES `forum_comments`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: articles (Artikel Edukatif)
CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `author_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `views_count` int DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: reports (Laporan)
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'monthly, quarterly, annual',
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `total_consultations` int DEFAULT 0,
  `total_users` int DEFAULT 0,
  `total_psikologs` int DEFAULT 0,
  `statistics` json,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','sent') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Struktur Tabel: chat_messages (Pesan Chat)
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `consultation_id` bigint unsigned NOT NULL,
  `sender_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci,
  `is_read` boolean DEFAULT false,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`consultation_id`) REFERENCES `consultations`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- SUMMARY TABEL DATABASE KUTKATHA
-- =============================================================================
-- Total Tabel: 13 tabel utama + tabel sistem

-- TABEL DETAIL:
-- 1. users              - Data pengguna (Admin, Psikolog, User Biasa, Pemerintah)
-- 2. psikologs          - Data psikolog dengan STR dan kredensial
-- 3. schedules          - Jadwal konsultasi psikolog
-- 4. bookings           - Pemesanan konsultasi oleh user
-- 5. payments           - Pembayaran untuk konsultasi
-- 6. consultations      - Riwayat dan catatan konsultasi
-- 7. feedbacks          - Rating dan review dari user
-- 8. forum_topics       - Topik diskusi di forum
-- 9. forum_posts        - Postingan dalam topik forum
-- 10. forum_comments    - Komentar terhadap postingan
-- 11. articles          - Artikel edukatif tentang psikologi
-- 12. reports           - Laporan statistik untuk pemerintah
-- 13. chat_messages     - Pesan chat selama konsultasi

-- RELASI UTAMA:
-- users (1) --> (Many) psikologs
-- users (1) --> (Many) schedules (melalui psikologs)
-- users (1) --> (Many) bookings
-- bookings (1) --> (1) payments
-- bookings (1) --> (1) consultations
-- consultations (1) --> (1) feedbacks
-- users (1) --> (Many) forum_topics
-- forum_topics (1) --> (Many) forum_posts
-- forum_posts (1) --> (Many) forum_comments
-- users (1) --> (Many) articles (sebagai author)
-- users (1) --> (Many) reports (sebagai creator)

-- LOGIN CREDENTIALS:
-- Admin: admin@kutkatha.id / password
-- Pemerintah: dinkes@kukar.go.id / password
-- Psikolog: siti.rahayu@kutkatha.id / password
-- User Biasa: user1@kutkatha.id / password

-- =============================================================================
