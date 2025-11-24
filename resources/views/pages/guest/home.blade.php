@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')
    <style>
        .hero-image {
            width: 100%;
            height: 260px;
            /* tinggi untuk mobile */
            background-image: url('{{ asset('assets/img/kemenag2.jpg') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        @media (min-width: 992px) {

            /* breakpoint lg Bootstrap */
            .hero-image {
                height: 85vh;
                /* full tinggi di desktop */
            }
        }
    </style>

    <main>
        {{-- Hero Section --}}
        <section class="hero bg-light">
            <div class="container border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6  ">
                        <div class=" py-4">
                            <h1 class="fw-bold text-primary mb-3 display-5">
                                Selamat Datang di SILAYANKRIS
                            </h1>
                            <p class="fs-5 mb-3">
                                Sistem Informasi Layanan Penyelenggara Kristen
                                Kementerian Agama Kota Surabaya
                            </p>
                            <p class="text-muted mb-4">
                                Akses berbagai layanan dan informasi penyelenggaraan Kristen
                                secara cepat, mudah, dan terintegrasi dalam satu sistem.
                            </p>
                            <button class="btn btn-primary btn-lg">
                                Mulai
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="hero-image "></div>
                    </div>
                </div>
            </div>

            <!-- PROFIL SECTION -->
            <div class="container border-bottom py-5 ">
                <div class="row align-items-start">

                    <!-- Foto -->
                    <div class="col-md-5 mb-4 mb-md-0 text-center">
                        <img src="{{ asset('assets/img/6 (1).jpg') }}" class="img-fluid rounded shadow-sm"
                            style="max-width: 100%; height: auto;">
                    </div>

                    <!-- Konten -->
                    <div class="col-md-7 ps-md-4">

                        <!-- Subheading -->
                        <p class="text-uppercase text-secondary fw-semibold mb-1" style="letter-spacing: .5px;">
                            Penyelenggara Kristen
                        </p>

                        <!-- Judul -->
                        <h1 class="fw-bold mb-4" style="font-size: 2.4rem; line-height: 1.3;">
                            Kantor Kementerian <br>
                            Agama Kota <br>
                            Surabaya.
                        </h1>

                        <!-- Box deskripsi -->
                        <div class="p-4 mb-4 rounded" style="background: #f7f9fb; border-left: 4px solid #dfb484;">
                            <p class="text-muted lh-lg mb-0" style="font-size: 0.97rem;">
                                Selamat Datang di Website Resmi Seksi Pendidikan Agama Islam (PAIS)
                                Kantor Kementerian Agama Kota Surabaya. Kami hadir disini untuk menjadi pusat
                                informasi dan layanan terpadu dalam bidang pendidikan agama Islam di Kota Surabaya.
                                Melalui platform ini, kami berkomitmen untuk menyediakan akses yang mudah bagi
                                para guru, siswa, dan masyarakat umum terhadap program, kebijakan, serta berita terbaru.
                                Mari bersama-sama kita wujudkan pendidikan agama Islam yang berkualitas, modern, dan
                                berkarakter untuk generasi penerus bangsa. Terima kasih atas kunjungan Anda.
                            </p>
                        </div>





                    </div>
                </div>
            </div>

            <!-- PELAYANAN SECTION -->
            <div class="container py-5 border-bottom">

                <div class="text-center mb-5">
                    <h6 class="fw-bold text-dark">
                        PELAYANAN SEKSI
                    </h6>
                    <h2 class="fw-bold fs-1 text-dark">
                        Penyelenggara Kristen
                    </h2>
                    {{-- <div class="mx-auto mt-2 bg-primary" style="width: 400px; height: 3px; "></div> --}}
                    <p class="text-muted mt-3 fs-6">
                        Pilih jenis layanan yang ingin Anda akses melalui sistem SILAYANKRIS.
                    </p>
                </div>

                <div class="row">
                    {{-- Card 1 --}}
                    <div class="col-md-6 mb-4">
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

                    {{-- Card 2 --}}
                    <div class="col-md-6 mb-4">
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

            <!-- PEGAWAI SECTION -->
            <div class="container py-5">

                <!-- Header -->
                <div class="text-center mb-5">
                    <h6 class="fw-bold text-dark">
                        PEGAWAI SEKSI
                    </h6>
                    <h2 class="fw-bold fs-1 text-dark">
                        Penyelenggara Kristen
                    </h2>

                </div>

                <div class="row g-4">

                    <!-- CARD 1 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow border-0 text-center p-4">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/6 (1).jpg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">John Doe</h5>
                            <p class="text-muted mb-3">Product Designer</p>
                        </div>
                    </div>
                    <!-- CARD 2 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow border-0 text-center p-4">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/6 (1).jpg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">John Doe</h5>
                            <p class="text-muted mb-3">Product Designer</p>
                        </div>
                    </div>
                    <!-- CARD 3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow border-0 text-center p-4">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/6 (1).jpg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">John Doe</h5>
                            <p class="text-muted mb-3">Product Designer</p>
                        </div>
                    </div>
                    <!-- CARD 4 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow border-0 text-center p-4">
                            <div class="team-img mx-auto mb-3">
                                <img src="{{ asset('assets/img/6 (1).jpg') }}" class="rounded-circle img-fluid">
                            </div>
                            <h5 class="fw-bold mb-0">John Doe</h5>
                            <p class="text-muted mb-3">Product Designer</p>
                        </div>
                    </div>



                </div>

            </div>
            
            <!-- LOGO SECTION -->

            <div class="container py-5  bg-light">
                <div class="row justify-content-center align-items-center text-center g-5">

                    <!-- Logo 1 -->
                    <div class="col-6 col-md-3">
                        <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid"
                            style="max-height: 120px; object-fit: contain;" alt="Logo 1">
                    </div>

                    <!-- Logo 2 -->
                    <div class="col-6 col-md-3">
                        <img src="{{ asset('assets/img/Logo UPN JATIM.png') }}" class="img-fluid"
                            style="max-height: 120px; object-fit: contain;" alt="Logo 2">
                    </div>

                </div>
            </div>


        </section>

        {{-- <div class="col-12 col-lg-6 order-2 order-lg-1 d-flex align-items-center border">
                <div class="px-4 px-md-5 py-5 py-lg-0 text-start">
                    <h1 class="fw-bold text-primary mb-3 display-5">
                        Selamat Datang di SILAYANKRIS
                    </h1>
                    <p class="fs-5 mb-3">
                        Sistem Informasi Layanan Penyelenggara Kristen
                        Kementerian Agama Kota Surabaya
                    </p>
                    <p class="text-muted mb-4">
                        Akses berbagai layanan dan informasi penyelenggaraan Kristen
                        secara cepat, mudah, dan terintegrasi dalam satu sistem.
                    </p>
                    <button class="btn btn-primary btn-lg">
                        Mulai
                    </button>
                </div>
            </div> --}}





    </main>




@endsection
