@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                SILAYANKRIS
            </a>

            @auth
                <a class="btn btn-outline-primary ms-auto" href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endauth
        </div>
    </nav>

    <main>
        {{-- Hero Section --}}
        <section class="hero py-5 text-center bg-light">
            <div class="container">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    Selamat Datang di SILAYANKRIS
                </h1>
                <p class="lead mb-4">
                    Sistem Informasi Layanan Penyelenggara Kristen  
                    Kementerian Agama Kota Surabaya
                </p>
                <p class="text-muted mb-5">
                    Platform ini digunakan untuk mengelola data <strong>pelayanan gereja</strong> dan  
                    <strong>berkas TPG guru</strong> secara digital dan terintegrasi.
                </p>

                <div class="row justify-content-center">
                    {{-- Card 1: Layanan Gereja --}}
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100">
                            <div class="card-body text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-building fs-1 text-primary"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Layanan Gereja</h5>
                                <p class="card-text text-muted">
                                    Akses informasi dan pengelolaan data gereja di wilayah Surabaya.
                                </p>
                                <a href="{{ route('login', ['type' => 'gereja']) }}" class="btn btn-primary mt-3">
                                    Masuk ke Layanan Gereja
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Pelayanan TPG Guru --}}
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100">
                            <div class="card-body text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-person-badge fs-1 text-success"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-3">Pelayanan TPG Guru</h5>
                                <p class="card-text text-muted">
                                    Unggah dan kelola berkas Tunjangan Profesi Guru secara online.
                                </p>
                                <a href="{{ route('login', ['type' => 'tpg']) }}" class="btn btn-success mt-3">
                                    Masuk ke Pelayanan TPG Guru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-0">
                &copy; 2025 <strong>SILAYANKRIS</strong> — Kementerian Agama Kota Surabaya.  
                <br>Seluruh hak cipta dilindungi.
            </p>
        </div>
    </footer>

@endsection
