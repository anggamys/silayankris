@extends('layouts.auth')

@section('title', 'Login - SILAYANKRIS')

@section('content')
<div class="card">
  <div class="card-body">
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="{{ url('/') }}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40">
        </span>
        <span class="app-brand-text demo text-body fw-bolder">SILAYANKRIS</span>
      </a>
    </div>
    <!-- /Logo -->

    {{-- Dynamic Title Section --}}
@if (request('type') === 'gereja')
  <h4 class="mb-2 text-primary">Login Layanan Gereja</h4>
  <p class="mb-4">Silakan login untuk mengakses data dan layanan gereja Anda.</p>
@elseif (request('type') === 'tpg')
  <h4 class="mb-2 text-success">Login Pelayanan TPG Guru</h4>
  <p class="mb-4">Masukkan akun Anda untuk mengelola berkas TPG guru secara online.</p>
@else
  <h4 class="mb-2">Welcome Back 👋</h4>
  <p class="mb-4">Please sign in to your account</p>
@endif

{{-- Form Login --}}
<form id="formAuthentication" method="POST" action="{{ route('login', ['type' => request('type')]) }}">
  @csrf
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input
      type="email"
      class="form-control @error('email') is-invalid @enderror"
      id="email"
      name="email"
      placeholder="Enter your email"
      value="{{ old('email') }}"
      required autofocus
    />
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="mb-3 form-password-toggle">
    <div class="d-flex justify-content-between">
      <label class="form-label" for="password">Password</label>
      <a href="#">
        <small>Forgot Password?</small>
      </a>
    </div>
    <div class="input-group input-group-merge">
      <input
        type="password"
        id="password"
        class="form-control @error('password') is-invalid @enderror"
        name="password"
        placeholder="••••••••••"
        required
      />
      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
      @error('password')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit">Sign In</button>
  </div>
</form>

      {{-- <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
          <label class="form-check-label" for="remember-me">Remember Me</label>
        </div>
      </div> --}}

      <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Sign In</button>
      </div>
    </form>

    @guest
    <p class="text-center">
      <span>New here?</span>
      <a href="">
        <span>Create an account</span>
      </a>
    </p>
    @endguest
  </div>
</div>
@endsection
