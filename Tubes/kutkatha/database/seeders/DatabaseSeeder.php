<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Psikolog;
use App\Models\Schedule;
use App\Models\ForumTopic;
use App\Models\ForumPost;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin Kutkatha',
            'email' => 'admin@kutkatha.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Tenggarong, Kutai Kartanegara',
            'email_verified_at' => now(),
        ]);

        // Create Pemerintah Account
        $pemerintah = User::create([
            'name' => 'Dinas Kesehatan Kukar',
            'email' => 'dinkes@kukar.go.id',
            'password' => Hash::make('password'),
            'role' => 'pemerintah',
            'phone' => '0541123456',
            'address' => 'Jl. Wolter Monginsidi No.1, Tenggarong',
            'email_verified_at' => now(),
        ]);

        // Create Psikologs
        $psikologData = [
            [
                'name' => 'Dr. Siti Rahayu, M.Psi',
                'email' => 'siti.rahayu@kutkatha.id',
                'specialization' => 'Psikologi Klinis',
                'str_number' => 'STR-PSI-2024001',
                'experience_years' => 8,
                'consultation_fee' => 150000,
                'bio' => 'Psikolog klinis dengan pengalaman 8 tahun menangani kasus depresi, kecemasan, dan gangguan mood. Lulusan Universitas Indonesia dengan spesialisasi terapi kognitif perilaku.',
                'education' => 'S2 Psikologi Klinis - Universitas Indonesia',
            ],
            [
                'name' => 'Andi Pratama, M.Psi',
                'email' => 'andi.pratama@kutkatha.id',
                'specialization' => 'Psikologi Anak & Remaja',
                'str_number' => 'STR-PSI-2024002',
                'experience_years' => 5,
                'consultation_fee' => 125000,
                'bio' => 'Fokus pada perkembangan anak dan remaja, termasuk masalah belajar, perilaku, dan emosional. Berpengalaman bekerja sama dengan sekolah-sekolah di Kutai Kartanegara.',
                'education' => 'S2 Psikologi Perkembangan - Universitas Airlangga',
            ],
            [
                'name' => 'Dr. Maya Kusuma, M.Psi',
                'email' => 'maya.kusuma@kutkatha.id',
                'specialization' => 'Psikologi Keluarga',
                'str_number' => 'STR-PSI-2024003',
                'experience_years' => 10,
                'consultation_fee' => 175000,
                'bio' => 'Pakar dalam konseling keluarga dan pernikahan. Membantu pasangan dan keluarga mengatasi konflik, komunikasi, dan masalah hubungan.',
                'education' => 'S3 Psikologi Keluarga - Universitas Gadjah Mada',
            ],
        ];

        foreach ($psikologData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'psikolog',
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => 'Kutai Kartanegara, Kalimantan Timur',
                'email_verified_at' => now(),
            ]);

            $psikolog = Psikolog::create([
                'user_id' => $user->id,
                'str_number' => $data['str_number'],
                'specialization' => $data['specialization'],
                'bio' => $data['bio'],
                'education' => $data['education'],
                'experience_years' => $data['experience_years'],
                'consultation_fee' => $data['consultation_fee'],
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]);

            // Create schedules for each psikolog
            $this->createSchedules($psikolog);
        }

        // Create Sample Users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@kutkatha.id",
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => 'Kutai Kartanegara, Kalimantan Timur',
                'email_verified_at' => now(),
            ]);
        }

        // Create Forum Topics
        $this->createForumTopics();

        // Create Articles
        $this->createArticles();

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('=== Login Credentials ===');
        $this->command->info('Admin: admin@kutkatha.id / password');
        $this->command->info('Pemerintah: dinkes@kukar.go.id / password');
        $this->command->info('Psikolog: siti.rahayu@kutkatha.id / password');
        $this->command->info('User: user1@kutkatha.id / password');
    }

    private function createSchedules(Psikolog $psikolog): void
    {
        $types = ['online', 'offline', 'chat'];

        // Create schedules for the next 14 days
        for ($day = 1; $day <= 14; $day++) {
            $date = now()->addDays($day);

            // Skip weekends
            if ($date->isWeekend()) continue;

            // Morning slot
            Schedule::create([
                'psikolog_id' => $psikolog->id,
                'date' => $date,
                'start_time' => '09:00',
                'end_time' => '10:00',
                'consultation_type' => $types[array_rand($types)],
                'is_available' => true,
            ]);

            // Afternoon slot
            Schedule::create([
                'psikolog_id' => $psikolog->id,
                'date' => $date,
                'start_time' => '14:00',
                'end_time' => '15:00',
                'consultation_type' => $types[array_rand($types)],
                'is_available' => true,
            ]);
        }
    }

    private function createForumTopics(): void
    {
        $user = User::where('role', 'user')->first();
        $psikolog = User::where('role', 'psikolog')->first();

        $topics = [
            [
                'title' => 'Bagaimana cara mengatasi kecemasan berlebihan?',
                'category' => 'Kecemasan',
                'description' => 'Saya sering merasa cemas berlebihan, terutama saat menghadapi situasi baru atau bertemu orang baru. Rasanya seperti jantung berdebar kencang dan tangan berkeringat. Ada yang punya tips untuk mengatasi ini?',
                'is_pinned' => true,
            ],
            [
                'title' => 'Tips menjaga kesehatan mental saat WFH',
                'category' => 'Tips & Motivasi',
                'description' => 'Sudah hampir 2 tahun WFH dan mulai merasa burnout. Work-life balance jadi sulit karena kerja dari rumah. Bagaimana cara kalian menjaga kesehatan mental selama WFH?',
            ],
            [
                'title' => 'Curhat: Merasa tidak dihargai di tempat kerja',
                'category' => 'Karir',
                'description' => 'Sudah 3 tahun bekerja tapi rasanya tidak ada apresiasi. Apakah saya yang terlalu sensitif atau memang wajar merasa seperti ini?',
            ],
        ];

        foreach ($topics as $topicData) {
            $topic = ForumTopic::create([
                'user_id' => $user->id,
                'title' => $topicData['title'],
                'category' => $topicData['category'],
                'description' => $topicData['description'],
                'is_pinned' => $topicData['is_pinned'] ?? false,
            ]);

            // Add response from psikolog
            ForumPost::create([
                'topic_id' => $topic->id,
                'user_id' => $psikolog->id,
                'content' => 'Terima kasih sudah berbagi. Perasaan yang Anda alami adalah hal yang wajar. Beberapa tips yang bisa membantu: 1) Teknik pernapasan dalam, 2) Journaling untuk mengekspresikan perasaan, 3) Olahraga teratur, 4) Jika berlanjut, jangan ragu untuk konsultasi dengan profesional.',
            ]);
        }
    }

    private function createArticles(): void
    {
        $psikolog = Psikolog::first();

        $articles = [
            [
                'title' => '5 Tanda Anda Membutuhkan Bantuan Profesional untuk Kesehatan Mental',
                'category' => 'Kesehatan Mental',
                'excerpt' => 'Mengenali tanda-tanda bahwa Anda mungkin membutuhkan bantuan profesional adalah langkah penting dalam menjaga kesehatan mental.',
                'content' => "Kesehatan mental sama pentingnya dengan kesehatan fisik. Namun, seringkali kita mengabaikan tanda-tanda bahwa kita membutuhkan bantuan profesional. Berikut adalah 5 tanda yang perlu Anda perhatikan:\n\n1. **Perubahan mood yang ekstrem**\nJika Anda mengalami perubahan mood yang signifikan dalam waktu singkat, atau mood yang ekstrem seperti sangat sedih atau sangat marah tanpa alasan jelas.\n\n2. **Kesulitan menjalani aktivitas sehari-hari**\nKetika masalah emosional mulai mengganggu pekerjaan, hubungan, atau aktivitas sehari-hari Anda.\n\n3. **Perubahan pola tidur atau makan**\nInsomnia, tidur berlebihan, kehilangan nafsu makan, atau makan berlebihan bisa menjadi tanda masalah kesehatan mental.\n\n4. **Penarikan diri dari sosial**\nMenghindari teman, keluarga, atau aktivitas yang dulu Anda nikmati.\n\n5. **Pikiran untuk menyakiti diri sendiri**\nJika Anda memiliki pikiran untuk menyakiti diri sendiri atau bunuh diri, segera cari bantuan profesional.\n\nJangan ragu untuk mencari bantuan. Psikolog dan psikiater terlatih untuk membantu Anda melewati masa-masa sulit.",
                'status' => 'published',
            ],
            [
                'title' => 'Mengenal Teknik Mindfulness untuk Mengurangi Stres',
                'category' => 'Tips & Trik',
                'excerpt' => 'Mindfulness adalah praktik yang dapat membantu Anda mengurangi stres dan meningkatkan kesejahteraan mental.',
                'content' => "Mindfulness adalah praktik memusatkan perhatian pada momen saat ini tanpa menghakimi. Teknik ini telah terbukti efektif dalam mengurangi stres, kecemasan, dan meningkatkan kesejahteraan secara keseluruhan.\n\n**Cara Memulai Mindfulness:**\n\n1. **Pernapasan sadar**\nDuduklah dengan nyaman, tutup mata, dan fokus pada napas Anda. Rasakan udara masuk dan keluar. Jika pikiran Anda mengembara, kembalikan fokus ke napas.\n\n2. **Body scan**\nBerbaring dan secara perlahan arahkan perhatian ke setiap bagian tubuh, dari ujung kaki hingga kepala.\n\n3. **Makan dengan sadar**\nNikmati makanan dengan penuh perhatian. Rasakan tekstur, rasa, dan aroma setiap suapan.\n\n4. **Berjalan dengan sadar**\nSaat berjalan, perhatikan sensasi kaki menyentuh tanah, gerakan tubuh, dan lingkungan sekitar.\n\nPraktikkan mindfulness selama 5-10 menit sehari dan rasakan perbedaannya dalam kehidupan Anda.",
                'status' => 'published',
            ],
        ];

        foreach ($articles as $articleData) {
            Article::create([
                'author_id' => $psikolog->user_id,
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'excerpt' => $articleData['excerpt'],
                'content' => $articleData['content'],
                'category' => $articleData['category'],
                'status' => $articleData['status'],
                'published_at' => $articleData['status'] === 'published' ? now() : null,
                'views_count' => rand(50, 500),
            ]);
        }
    }
}
