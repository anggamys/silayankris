@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                SILAYANKRIS
            </a>

            <a class="ms-auto" href="{{ route('admin.dashboard') }}">Page</a>

            @auth
                <a class="btn btn-outline-primary ms-auto" href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endauth
        </div>
    </nav>

    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Judul --}}
         <div class="row">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Berita SILAYANKRIS</h3>
        </div>
    </div>
        {{-- Search dan Reset --}}
        <div class="row  mb-3 ">
            <div class="col-12 col-md-6">
                <form method="GET" class="w-100 d-flex align-items-center gap-2">
                    {{-- Input pencarian --}}
                    <div class="input-group ">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                            placeholder="Cari judul berita...">
                        <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                    </div>

                    <a href="{{ url()->current() }}"
                        class="btn btn-outline-secondary border d-flex align-items-center gap-1">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        <span>Reset</span>
                    </a>
                </form>
            </div>
        </div>
        {{-- Card Hero Berita --}}
        <div class="row  mb-3">
            <div class="col-md-12 ">
                <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0  pb-3"
                    style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">
                    <div class="row g-4">

                        {{-- Gambar --}}
                        <div class="col-md-7">
                            <img class="img-fluid rounded-start" src="{{ asset('assets/img/news/18.jpg') }}"
                                alt="Card image" style="height: 100%; max-height: 400px; object-fit: cover; width: 100%;">
                        </div>

                        {{-- Isi Card --}}
                        <div class="col-md-5">
                            <div class="card-body p-0">
                                <h5 class="card-title">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magnam rem voluptatem dolorum voluptate eligendi quas.</h5>

                                <p class="card-text">
                                    This is a wider card with supporting text below as a natural lead-in to additional
                                    content. This content is a little bit longer.
                                </p>

                                <p class="card-text">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        {{-- Card All Berita --}}
        <div class="row">
            <div class="col-md-9">
                <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0  pb-3"
                    style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">
                    <div class="row g-4 border-bottom-2">
                        <div class="col-md-3">
                            <img class="img-fluid rounded" src="{{ asset('assets/img/news/18.jpg') }}" alt="Card image"
                                style="height: 100%; max-height: 200px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-md-9 ">
                            <div class="card-body p-0">
                                <h5 class="card-title">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum provident reiciendis natus dignissimos, doloribus adipisci.</h5>
                                <p class="card-text">This is a wider card...</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0  pb-3"
                    style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">
                    <div class="row g-4 border-bottom-2">
                        <div class="col-md-3">
                            <img class="img-fluid rounded" src="{{ asset('assets/img/news/18.jpg') }}" alt="Card image"
                                style="height: 100%; max-height: 200px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-md-9 ">
                            <div class="card-body p-0">
                                <h5 class="card-title">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum provident reiciendis natus dignissimos, doloribus adipisci.</h5>
                                <p class="card-text">This is a wider card...</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0  pb-3"
                    style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">
                    <div class="row g-4 border-bottom-2">
                        <div class="col-md-3">
                            <img class="img-fluid rounded" src="{{ asset('assets/img/news/18.jpg') }}" alt="Card image"
                                style="height: 100%; max-height: 200px; object-fit: cover; width: 100%;">
                        </div>
                        <div class="col-md-9 ">
                            <div class="card-body p-0">
                                <h5 class="card-title">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum provident reiciendis natus dignissimos, doloribus adipisci.</h5>
                                <p class="card-text">This is a wider card...</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-none">
                    <h5 class="fw-bold mb-3 border-bottom pb-2 d-inline-block">
                        Terpopuler
                    </h5>

                    <div class="d-flex flex-column gap-3">

                        <div class="d-flex">
                            <span class="fw-bold text-primary me-3 fs-4">1</span>
                            <a href="#" class="text-dark text-decoration-none fw-medium">
                                Viral Video Gus Elham Cium Anak Perempuan, Wamenag: Tidak Pantas!
                            </a>
                        </div>

                        <div class="d-flex">
                            <span class="fw-bold text-primary me-3 fs-4">2</span>
                            <a href="#" class="text-dark text-decoration-none fw-medium">
                                Menag Lantik Rektor UIN, Kepala Kanwil Kemenag Provinsi dan Kepala Biro PTKN
                            </a>
                        </div>

                        <div class="d-flex">
                            <span class="fw-bold text-primary me-3 fs-4">3</span>
                            <a href="#" class="text-dark text-decoration-none fw-medium">
                                Ini Logo Hari Guru Nasional 2025, Apa Makna dan Filosofinya?
                            </a>
                        </div>

                        <div class="d-flex">
                            <span class="fw-bold text-primary me-3 fs-4">4</span>
                            <a href="#" class="text-dark text-decoration-none fw-medium">
                                Jelang Hari Guru, 101.786 Guru Madrasah dan Pendidikan Agama Lulus PPG
                            </a>
                        </div>

                        <div class="d-flex">
                            <span class="fw-bold text-primary me-3 fs-4">5</span>
                            <a href="#" class="text-dark text-decoration-none fw-medium">
                                Ini Juara Olimpiade Madrasah Indonesia Nasional 2025 Bidang Sains
                            </a>
                        </div>

                        <div class="d-flex">
                            <span class="fw-bold text-primary me-3 fs-4">6</span>
                            <a href="#" class="text-dark text-decoration-none fw-medium">
                                Percepatan Sertifikasi, Hadiah Kemenag di Hari Guru Nasional 2025
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
