@extends('layouts.app')

@section('title', 'SILAYANKRIS - Kementerian Agama Kota Surabaya')

{{-- Landing Page --}}
@section('content')

    {{-- <nav class="navbar navbar-expand-lg border-bottom  bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                SILAYANKRIS
            </a>

            <a class="ms-auto" href="{{ route('admin.dashboard') }}">Page</a>

            @auth
                <a class="btn btn-outline-primary ms-auto" href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endauth
        </div>
    </nav> --}}
    <div class="container-fluid  py-4 bg-primary text-light">
        <div class="container pb-3 ">
            <h1 class="fw-bold mb-0">Berita</h1>
            <p class="text-light fs-6 mb-0">Pusat pengumuman layanan kristen</p>
        </div>
    </div>


    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Judul --}}

        {{-- Search dan Reset --}}
        <div class="row  mb-3 ">
            <div class="col-12 col-md-6 flex-grow-1">
                <form method="GET" class="w-100 d-flex align-items-center gap-2">
                    {{-- Input pencarian --}}
                    <div class="input-group ">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                            placeholder="Cari judul berita..." style="width: 50%; height: 50px;">
                        <button class="btn btn-outline-secondary border" type="submit">Cari</button>
                    </div>

                    <a href="{{ url()->current() }}"
                        class="btn btn-lg  btn-outline-secondary border d-flex align-items-center gap-1">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </form>
            </div>
        </div>
        {{-- Card Hero Berita --}}
        @if ($beritas->count() > 0)
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0 pb-3"
                        style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">

                        <div class="row g-4">

                            {{-- HERO GAMBAR --}}
                            <div class="col-md-7">
                                <a href="/news/{{ $beritas->first()->id }}">
                                    <div class="img-hover-slide">
                                        <img class="img-fluid rounded news-image"
                                            src="{{ asset('storage/' . $beritas->first()->gambar_path) }}"
                                            style="width: 100%; height: 350px; object-fit: cover;">
                                    </div>
                                </a>
                            </div>

                            {{-- HERO TEKS --}}
                            <div class="col-md-5">
                                <div class="card-body p-0">
                                    <a href="/news/{{ $beritas->first()->id }}"
                                        class="text-decoration-none news-title card-title h2">
                                        {{ Str::limit($beritas->first()->judul, 75, '...') }}
                                    </a>
                                    <p class="card-text fs-6 mt-2">{{ Str::limit($beritas->first()->isi, 250, '...') }}</p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{ $beritas->first()->created_at->locale('id')->translatedFormat('d F Y') }}
                                        </small>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert bg-primary text-light mt-4">
                Belum ada berita yang tersedia.
            </div>
        @endif

        {{-- Card All Berita --}}
        <div class="row">
            <div class="col-md-9">
                @foreach ($beritas->skip(1) as $berita)
                    <div class="card border-0 shadow-none bg-transparent mb-3 border-bottom border-md rounded-0  pb-3"
                        style="border-bottom-style: dashed !important; border-color: rgb(179, 174, 174) !important;">
                        <div class="row g-4 border-bottom-2">
                            <div class="col-md-3">
                                <a href="/news/1">
                                    <div class="img-hover-slide">
                                        <img class="img-fluid rounded news-image"
                                            src="{{ asset('storage/' . $berita->gambar_path) }}"
                                            style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px;">

                                    </div>
                                </a>
                            </div>
                            <div class="col-md-9 ">
                                <div class="card-body p-0">
                                    <a href="/news/1" class="text-decoration-none news-title card-title h5">
                                        {{ Str::limit($berita->judul, 50, '...') }}
                                    </a>
                                    <p class="card-text mt-2">{{ Str::limit($berita->isi, 150, '...') }}</p>
                                    <p class="card-text"><small
                                            class="text-muted">{{ \Carbon\Carbon::parse($berita->created_at)->locale('id')->translatedFormat('d F Y') }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $beritas->links('pagination::bootstrap-5') }}
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
