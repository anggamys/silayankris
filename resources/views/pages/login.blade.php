@extends('layouts.auth')

@section('title', 'Login - SILAYANKRIS')

@section('content')
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="card shadow-lg border-0 rounded-4" style="max-width: 450px; width: 100%;">
            <div class="card-body p-5 text-center">
                {{-- Logo & Title --}}
                <div class="mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Kemenag" width="80" class="mb-3">
                    <h3 class="fw-bold text-primary">SILAYANKRIS</h3>
                    <p class="text-muted mb-0">Kementerian Agama Kota Surabaya</p>
                </div>

                {{-- Dynamic Title --}}
                @if (request('type') === 'gereja')
                    <h5 class="fw-semibold mt-4 mb-2 text-dark">Login Layanan Gereja</h5>
                    <p class="text-muted mb-4">Silakan login untuk mengakses data dan layanan gereja Anda.</p>
                @elseif (request('type') === 'tpg')
                    <h5 class="fw-semibold mt-4 mb-2 text-dark">Login Pelayanan TPG Guru</h5>
                    <p class="text-muted mb-4">Masukkan akun Anda untuk mengelola berkas TPG guru secara online.</p>
                @else
                    <h5 class="fw-semibold mt-4 mb-2 text-dark">Login SILAYANKRIS</h5>
                    <p class="text-muted mb-4">Silakan login untuk melanjutkan ke layanan Anda.</p>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                            name="email" id="email" placeholder="Masukkan email" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 text-start">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror"
                            name="password" id="password" placeholder="Masukkan password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>



@endsection
