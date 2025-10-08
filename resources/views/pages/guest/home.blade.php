@extends('layouts.app')

@section('title', 'Pendidikan Agama Islam Kota Surabaya')

{{-- landing page --}}
@section('content')

    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Pendidikan Agama Islam Kota Surabaya</a>

            @auth
                <button>
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </button>
            @endauth
        </div>
    </nav>

    <main>
        {{-- Hero Section --}}
        <section class="hero">
            <div class="container">
                <h1 class="display-4">Selamat Datang di Pendidikan Agama Islam Kota Surabaya</h1>
                <p class="lead">Pendidikan Agama Islam Kota Surabaya adalah tempat yang didedikasikan untuk memberikan
                    pendidikan agama islam yang berkualitas.</p>
                <a href="/" class="btn btn-primary btn-lg">Form</a>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="features py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Fitur Utama</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Pendidikan Agama Islam</h5>
                                <p class="card-text">Pendidikan agama islam yang berkualitas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Pembelajaran Interaktif</h5>
                                <p class="card-text">Pembelajaran interaktif yang menarik.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Pengajar Berpengalaman</h5>
                                <p class="card-text">Pengajar yang berpengalaman di bidangnya.</p>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>

    {{-- footer --}}
    <footer>
        <div class="container text-center py-4">
            <p>&copy; 2025 Pendidikan Agama Islam Kota Surabaya. All rights reserved.</p>
        </div>
    </footer>
@endsection
