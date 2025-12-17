@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="fw-bold mb-4 text-center">Tentang Kutkatha</h1>

            <div class="card mb-4">
                <div class="card-body p-5">
                    <h4 class="text-primary-custom mb-3">Apa itu Kutkatha?</h4>
                    <p>
                        <strong>Kutai Kathana (Kutkatha)</strong> merupakan platform digital yang menyediakan layanan konseling
                        psikologis online dan offline bagi masyarakat Kutai Kartanegara. Tujuan utamanya adalah meningkatkan
                        kesadaran akan kesehatan mental dan mempermudah akses masyarakat terhadap bantuan psikolog profesional,
                        terutama di daerah yang masih terbatas fasilitas psikologinya.
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body p-5">
                    <h4 class="text-primary-custom mb-3">Visi</h4>
                    <p>
                        Menjadi platform digital layanan kesehatan mental terdepan di Kalimantan Timur yang memberikan
                        akses mudah dan berkualitas kepada masyarakat untuk mendapatkan bantuan psikologis profesional.
                    </p>

                    <h4 class="text-primary-custom mb-3 mt-4">Misi</h4>
                    <ul>
                        <li>Menyediakan layanan konseling psikologis yang mudah diakses oleh seluruh lapisan masyarakat</li>
                        <li>Mengedukasi masyarakat tentang pentingnya kesehatan mental</li>
                        <li>Membangun komunitas yang saling mendukung dalam hal kesehatan mental</li>
                        <li>Berkolaborasi dengan pemerintah daerah untuk program kesehatan mental</li>
                        <li>Meningkatkan kualitas hidup masyarakat Kutai Kartanegara</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body p-5">
                    <h4 class="text-primary-custom mb-3">Layanan Kami</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Konsultasi Online</h6>
                                    <small class="text-muted">Video call dengan psikolog</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Konsultasi Offline</h6>
                                    <small class="text-muted">Tatap muka langsung</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Chat Konseling</h6>
                                    <small class="text-muted">Konsultasi via chat</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Forum Komunitas</h6>
                                    <small class="text-muted">Diskusi & berbagi pengalaman</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Edukasi Mental Health</h6>
                                    <small class="text-muted">Artikel & materi edukatif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-muted mb-4">Didukung oleh:</p>
                <h5 class="text-primary-custom">
                    <i class="fas fa-landmark me-2"></i>
                    Pemerintah Kabupaten Kutai Kartanegara
                </h5>
            </div>
        </div>
    </div>
</div>
@endsection
