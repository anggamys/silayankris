@extends('layouts.appadmin')

@section('title', 'Detail Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Data Pengguna</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detail Data Pengguna</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Data Pengguna</h5>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-2">
                {{-- FOTO KIRI --}}
                <div class="col-md-3 text-center mb-3">

                    @php
                        $profile_photo_path = str_replace(
                            '.' . pathinfo($user->profile_photo_path, PATHINFO_EXTENSION),
                            '.jpg',
                            $user->profile_photo_path,
                        );
                    @endphp

                    @if ($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $profile_photo_path) }}" class="img-thumbnail rounded shadow-sm"
                            style="width: 305px; height: 305px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                            class="img-thumbnail rounded shadow-sm" style="width: 305px; height: 305px; object-fit: cover;">
                    @endif
                </div>

                {{-- FORM KANAN (LABEL TETAP RATA KIRI) --}}
                <div class="col-md-9">

                    {{-- PERAN --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Peran</label>
                        <select class="form-select" disabled>
                            <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="staff-gereja" {{ $user->role == 'staff-gereja' ? 'selected' : '' }}>Pengurus
                                Gereja</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Nama</label>
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    </div>

                    {{-- NOMOR TELEPON --}}
                    <div class="mb-3">
                        <label class="form-label text-start d-block">Nomor Telepon</label>
                        <input type="text" class="form-control" value="{{ $user->nomor_telepon }}" readonly>
                    </div>
                </div>
            </div>

            {{-- FORM GURU --}}
            @if ($user->role === 'guru' && $user->guru)
                <hr>
                <h5>Data Guru</h5>

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" class="form-control" value="{{ $user->guru->nip }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" value="{{ $user->guru->tempat_lahir }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($user->guru->tanggal_lahir)->translatedFormat('d F Y') }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tempat Mengajar (Sekolah)</label>
                    @if ($user->guru && $user->guru->sekolah && $user->guru->sekolah->count())
                        @foreach ($user->guru->sekolah as $sekolah)
                            <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
                        @endforeach
                    @else
                        <input type="text" class="form-control" value="-" readonly>
                    @endif
                </div>
            @endif

            {{-- FORM STAFF GEREJA --}}
            @if ($user->role === 'staff-gereja' && $user->staffGereja)
                <hr>
                <h5>Data Staff Gereja</h5>

                <div class="mb-3">
                    <label class="form-label">Gembala Sidang</label>
                    <input type="text" class="form-control" value="{{ $user->staffGereja->gembala_sidang }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gereja</label>
                    <select class="form-select" disabled>
                        @foreach ($gerejas as $gereja)
                            <option value="{{ $gereja->id }}"
                                {{ $user->staffGereja->gereja_id == $gereja->id ? 'selected' : '' }}>
                                {{ $gereja->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            {{-- TANGGAL DIBUAT --}}
            <div class="mb-3">
                <label class="form-label">Dibuat Pada</label>
                <input type="text" class="form-control" value="{{ $user->created_at->translatedFormat('d F Y, H:i') }}"
                    readonly>
            </div>

            {{-- TANGGAL DIUPDATE --}}
            <div class="mb-3">
                <label class="form-label">Diperbarui Pada</label>
                <input type="text" class="form-control" value="{{ $user->updated_at->translatedFormat('d F Y, H:i') }}"
                    readonly>
            </div>
        </div>
    </div>
@endsection
