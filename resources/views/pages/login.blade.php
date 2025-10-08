@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h4 class="mb-2">Login</h4>
    <p class="text-muted mb-4">Masukkan email dan password untuk login</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                id="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>

        {{-- @guest
            <p class="mt-3">Belum memiliki akun? <a href="{{ route('login') }}">Daftar di sini</a></p>
        @endguest --}}
    </form>
@endsection
