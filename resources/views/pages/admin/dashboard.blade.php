@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-light sidebar border-end p-0 ">
                <div class="position-sticky pt-3">
                    <div class="text-center py-4 border-bottom">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                            style="height:48px;width:48px;object-fit:contain;">
                        <h5 class="mt-2 mb-0">KEBAYAPAIS</h5>
                    </div>
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                    </ul>
                    <div class="text-center py-4 border-top">
                        {{-- User Info --}}
                        <div class="mb-3">
                            <p class="text-muted mb-0">{{ ucfirst(Auth::user()->email) }}</p>
                            <p class="mb-0">{{ ucfirst(Auth::user()->name) }}</p>
                            <p class="text-muted mb-0">{{ Auth::user()->role }}</p>
                        </div>

                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">Logout</a>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-4 py-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card text-bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Statistik 1</h5>
                                <p class="card-text">Isi statistik atau info singkat di sini.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Statistik 2</h5>
                                <p class="card-text">Isi statistik atau info singkat di sini.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Statistik 3</h5>
                                <p class="card-text">Isi statistik atau info singkat di sini.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan konten dashboard lainnya di sini -->
            </main>
        </div>
    </div>
@endsection
