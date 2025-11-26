@extends('layouts.app')

@section('title', $berita->judul . ' - SILAYANKRIS')

@section('content')
    <div class="container-fluid  pt-3  text-dark border-bottom">
        <div class="container pb-3 ">
            <a href="" class="text-dark fs-6 mb-0 text-decoration-none">Berita</a>
            <span>></span>
            <span class="text-dark fs-6 mb-0 text-decoration-none ">{{ $berita->judul }}</span>
        </div>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row ">

            {{-- Kolom Konten Utama --}}
            <div class="col-md-9">
                <div class="card border-0 shadow-none" style="border-radius: 14px;">
                    <div class="card-body px-4 pt-4 pb-0">
                        <h2 class="fw-bold mb-2">{{ $berita->judul }}</h2>

                        <p class="text-muted small mb-3">
                            Diposting oleh:
                            <span class="fw-semibold text-dark">{{ $berita->user->name }}</span> ·
                            {{ $berita->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            {{-- Kolom Konten Utama --}}
            <div class="col-md-9">
                <div class="card border-0 shadow-none" style="border-radius: 14px;">



                    {{-- Gambar Berita --}}
                    @if ($berita->gambar_path)
                        <div class="w-100 bg-light d-flex justify-content-center align-items-center"
                            style="max-height: 600px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $berita->gambar_path) }}" class="img-fluid"
                                style="max-height: 600px; width: auto; object-fit: contain; padding: 10px;"
                                alt="Gambar Berita">
                        </div>
                    @endif

                    <div class="card-body px-4 py-4">
                        <p class="card-text fs-5" style="font-size: 17px; line-height: 1.75;">
                            {!! nl2br(e($berita->isi)) !!}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Kolom Rekomendasi --}}
            <div class="col-md-3">

                <div class="card shadow-sm border-0 p-3" style="border-radius: 14px;">
                    <h5 class="fw-bold mb-3">Rekomendasi Berita</h5>

                    @foreach ($beritaPopuler as $item)
                        @if ($item->id !== $berita->id)
                            <a href="{{ route('berita.show', $item->slug) }}"
                                class="d-flex align-items-center text-decoration-none text-dark mb-3 p-2 rounded"
                                style="transition: 0.2s;">

                                {{-- Thumbnail Berita --}}
                                <div class="me-3 rounded overflow-hidden bg-light"
                                    style="width: 65px; height: 65px; flex-shrink: 0;">

                                    @if ($item->gambar_path)
                                        <img src="{{ asset('storage/' . $item->gambar_path) }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 bg-secondary"></div>
                                    @endif
                                </div>

                                {{-- Info Berita --}}
                                <div style="line-height: 1.2;">
                                    <div class="fw-semibold text-dark" style="font-size: 15px;">
                                        {{ Str::limit($item->judul, 40) }}
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $item->created_at->format('d M Y') }}
                                    </small>
                                </div>

                            </a>
                        @endif
                    @endforeach
                </div>

            </div>


        </div>
    </div>
@endsection
