@extends('layouts.appadmin')

@section('title', 'Detail Berita')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.berita.index') }}" class="text-decoration-none">Manajemen Berita</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
@endsection

@section('content')
    <div class="card shadow-sm border-0 mb-4 p-3">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold fs-4">Detail Berita</h5>
        </div>

        <div class="card-body">
            {{-- Form detail berita --}}
            <form>
                @csrf

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control" id="judul" name="judul" readonly
                        value="{{ $berita->judul }}">
                </div>

                {{-- Isi --}}
                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Berita</label>
                    <textarea class="form-control" id="isi" name="isi" rows="6" readonly>{{ $berita->isi }}</textarea>
                </div>

                {{-- Gambar --}}
                <div class="mb-3">
                    <label for="gambar_path" class="form-label">Gambar Berita</label>
                    @if ($berita->gambar_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $berita->gambar_path) }}" alt="Gambar Berita"
                                class="img-fluid rounded shadow-sm border" style="max-width: 400px;">
                        </div>
                    @else
                        <p class="text-muted fst-italic">Tidak ada gambar yang diunggah.</p>
                    @endif
                </div>

                {{-- Info tambahan --}}
                <div class="mt-4">
                    <p class="text-muted mb-1">
                        <strong>Ditulis oleh:</strong> {{ $berita->user->name ?? 'Tidak diketahui' }}
                    </p>
                    <p class="text-muted">
                        <strong>Dibuat
                            pada: </strong>{{ \Carbon\Carbon::parse($berita->created_at)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y H:i') }}



                    </p>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning text-white">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
