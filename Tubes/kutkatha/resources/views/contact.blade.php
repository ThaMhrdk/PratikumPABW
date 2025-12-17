@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="fw-bold mb-4 text-center">Hubungi Kami</h1>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-primary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-map-marker-alt fa-lg text-primary-custom"></i>
                            </div>
                            <h5>Alamat</h5>
                            <p class="text-muted mb-0">
                                Jl. Wolter Monginsidi No. 1<br>
                                Tenggarong, Kutai Kartanegara<br>
                                Kalimantan Timur 75514
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-primary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-phone fa-lg text-primary-custom"></i>
                            </div>
                            <h5>Telepon</h5>
                            <p class="text-muted mb-0">
                                (0541) 123-4567<br>
                                +62 812-3456-7890<br>
                                Senin - Jumat: 08:00 - 17:00
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-primary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-envelope fa-lg text-primary-custom"></i>
                            </div>
                            <h5>Email</h5>
                            <p class="text-muted mb-0">
                                info@kutkatha.id<br>
                                support@kutkatha.id<br>
                                admin@kutkatha.id
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body p-4 text-center">
                            <div class="rounded-circle bg-primary-custom bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-share-alt fa-lg text-primary-custom"></i>
                            </div>
                            <h5>Sosial Media</h5>
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="#" class="text-primary-custom fs-4"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="text-primary-custom fs-4"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="text-primary-custom fs-4"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-primary-custom fs-4"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body p-5">
                    <h4 class="text-center mb-4">Kirim Pesan</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Subjek</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pesan</label>
                                <textarea class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
