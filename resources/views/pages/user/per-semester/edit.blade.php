@extends('layouts.app')

@section('title', 'Detail Berkas Per-Semester')

@section('content')

    <div class="container-fluid pt-3 text-dark border-bottom">
        <div class="container pb-3">
            <a href="/home" class="text-dark fs-6 mb-0 text-decoration-none">Home</a>
            <span class="mx-2">></span>
            <a href="" class="text-dark fs-6 mb-0 text-decoration-none">Layanan</a>
            <span class="mx-2">></span>
            <a href="/user/persemester" class="text-dark fs-6 mb-0 text-decoration-none">Lengkapi Berkas Per-Semester</a>
            <span class="mx-2">></span>
            <span class="text-dark fs-6 mb-0">Detail Berkas Per-Semester</span>
        </div>
    </div>

    <div class="container-fluid  py-4 bg-primary text-light">
        <div class="container pb-3 ">
            <h1 class="fw-bold mb-0">Detail berkas Per-Semester</h1>
            <p class="text-light fs-6 mb-0">Layanan Guru untuk melihat detail berkas per-semester</p>
        </div>
    </div>

    <div class="container py-5">
        {{-- HITUNG PROGRESS --}}
        @php
            $totalField = 11;
            $uploaded = collect([
                $perSemester->sk_pbm_path,
                $perSemester->sk_terakhir_berkala_path,
                $perSemester->sp_bersedia_mengembalikan_path,
                $perSemester->sp_kebenaran_berkas_path,
                $perSemester->sp_perangkat_pembelajaran_path,
                $perSemester->keaktifan_simpatika_path,
                $perSemester->berkas_s28a_path,
                $perSemester->berkas_skmt_path,
                $perSemester->permohonan_skbk_path,
                $perSemester->berkas_skbk_path,
                $perSemester->sertifikat_pengembangan_diri_path,
            ])
                ->filter()
                ->count();

            $progress = ($uploaded / $totalField) * 100;

            $statusBadgeClass =
                [
                    'menunggu' => 'badge bg-label-warning',
                    'ditolak' => 'badge bg-label-danger',
                    'diterima' => 'badge bg-label-success',
                    'belum lengkap' => 'badge bg-label-secondary',
                ][$perSemester->status] ?? 'badge bg-label-secondary';
        @endphp

        {{-- HEADER UTAMA --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            <h4 class="fw-bold">
                Detail Berkas Per-semester
                <span class="text-muted d-block d-md-inline mt-1 mt-md-0 ms-md-2 text-muted">
                    {{ \Carbon\Carbon::parse($perSemester->periode_per_semester)->translatedFormat('(F Y)') }}
                </span>
            </h4>

            <a href="{{ route('user.persemester.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-5"></div>
        {{-- CARD: PROGRESS + STATUS --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Progress Pengajuan</h5>
            </div>

            <div class="card-body">

                {{-- PROGRESS --}}
                <label class="form-label fw-semibold">Kelengkapan Berkas</label>
                <div class="progress mb-2" style="height: 18px;">
                    <div class="progress-bar 
                    @if ($progress == 100) bg-success
                    @elseif($progress >= 50) bg-warning text-dark
                    @else bg-danger @endif"
                        style="width: {{ $progress }}%;">
                        {{ round($progress) }}%
                    </div>
                </div>
                <small class="text-muted">{{ $uploaded }} dari {{ $totalField }} dokumen terupload</small>

                <hr>

                {{-- STATUS --}}
                <label class="form-label fw-semibold">Status Pengajuan</label><br>
                <span class="badge {{ $statusBadgeClass }} px-3 py-2 text-capitalize">
                    {{ $perSemester->status }}
                </span>

                {{-- CATATAN --}}
                @if ($perSemester->catatan)
                    <div class="mt-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea class="form-control" rows="3" readonly>{{ $perSemester->catatan }}</textarea>
                    </div>
                @endif

            </div>
        </div>



        {{-- CARD: INFORMASI GURU --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Informasi Guru</h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->user->name }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->nip }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->user->nomor_telepon }}"
                            readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" value="{{ $perSemester->guru->tempat_lahir }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control"
                            value="{{ $perSemester->guru->tanggal_lahir?->format('d F Y') }}" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Asal Sekolah Induk</label>
                        @if ($perSemester->guru && $perSemester->guru->sekolah && $perSemester->guru->sekolah->count())
                            @foreach ($perSemester->guru->sekolah as $sekolah)
                                <input type="text" class="form-control mb-1" value="{{ $sekolah->nama }}" readonly>
                            @endforeach
                        @else
                            <input type="text" class="form-control" value="-" readonly>
                        @endif
                    </div>

                </div>
            </div>
        </div>


        {{-- Periode Per Semester --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="fw-semibold mb-0">Periode Per-semester</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="periode_per_semester" class="form-label">Periode Per-semester</label>
                    <input type="text" name="periode_per_semester" id="periode_per_semester"
                        class="form-control @error('periode_per_semester') is-invalid @enderror"
                        value="{{ old('periode_per_semester', $perSemester->periode_per_semester ? \Carbon\Carbon::parse($perSemester->periode_per_semester)->translatedFormat('F Y') : '') }}"
                        readonly>

                    @error('periode_per_semester')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>


        {{-- CARD: FILES --}}
        <form action="{{ route('user.persemester.update', $perSemester) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-semibold mb-0">Berkas Upload</h5>
                </div>

                <div class="card-body">

                    @php
                        $files = [
                            'Surat Keterangan PBM' => $perSemester->sk_pbm_path,
                            'Surat Keterangan Terakhir atau Berkala' => $perSemester->sk_terakhir_berkala_path,
                            'Surat Pernyataan Bersedia Mengembalikan' => $perSemester->sp_bersedia_mengembalikan_path,
                            'Surat Pernyataan Kebenaran Berkas' => $perSemester->sp_kebenaran_berkas_path,
                            'Surat Pernyataan Perangkat Pembelajaran' => $perSemester->sp_perangkat_pembelajaran_path,
                            'Bukti Keaktifan SIMPATIKA' => $perSemester->keaktifan_simpatika_path,
                            'Berkas S28a' => $perSemester->berkas_s28a_path,
                            'Berkas SKMT' => $perSemester->berkas_skmt_path,
                            'Permohonan SKBK' => $perSemester->permohonan_skbk_path,
                            'Berkas SKBK' => $perSemester->berkas_skbk_path,
                            'Sertifikat Pengembangan Diri' => $perSemester->sertifikat_pengembangan_diri_path,
                        ];
                    @endphp

                    {{-- Surat Keterangan PBM --}}
                    <div class="mb-3">
                        <label for="sk_pbm_path" class="form-label">Surat Keterangan PBM (File)</label>

                        <input type="file" name="sk_pbm_path" id="sk_pbm_path" class="form-control"
                            accept=".pdf">

                        {{-- Jika file ADA --}}
                        @if ($perSemester->sk_pbm_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->sk_pbm_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->sk_pbm_path) }}
                                </span>
                            </div>
                        @else
                            {{-- Jika file TIDAK ADA --}}
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Surat Keterangan Terakhir atau Berkala --}}
                    <div class="mb-3">
                        <label for="sk_terakhir_berkala_path" class="form-label">Surat Keterangan Terakhir atau Berkala (File)</label>

                        <input type="file" name="sk_terakhir_berkala_path" id="sk_terakhir_berkala_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->sk_terakhir_berkala_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->sk_terakhir_berkala_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->sk_terakhir_berkala_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Surat Pernyataan Bersedia Mengembalikan --}}
                    <div class="mb-3">
                        <label for="sp_bersedia_mengembalikan_path" class="form-label">Surat Pernyataan Bersedia Mengembalikan (File)</label>

                        <input type="file" name="sp_bersedia_mengembalikan_path" id="sp_bersedia_mengembalikan_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->sp_bersedia_mengembalikan_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->sp_bersedia_mengembalikan_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->sp_bersedia_mengembalikan_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Surat Pernyataan Kebenaran Berkas --}}
                    <div class="mb-3">
                        <label for="sp_kebenaran_berkas_path" class="form-label">Surat Pernyataan Kebenaran Berkas (File)</label>

                        <input type="file" name="sp_kebenaran_berkas_path" id="sp_kebenaran_berkas_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->sp_kebenaran_berkas_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->sp_kebenaran_berkas_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->sp_kebenaran_berkas_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Surat Pernyataan Perangkat Pembelajaran --}}
                    <div class="mb-3">
                        <label for="sp_perangkat_pembelajaran_path" class="form-label">Surat Pernyataan Perangkat Pembelajaran (File)</label>

                        <input type="file" name="sp_perangkat_pembelajaran_path" id="sp_perangkat_pembelajaran_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->sp_perangkat_pembelajaran_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->sp_perangkat_pembelajaran_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->sp_perangkat_pembelajaran_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Bukti Keaktifan SIMPATIKA --}}
                    <div class="mb-3">
                        <label for="keaktifan_simpatika_path" class="form-label">Bukti Keaktifan SIMPATIKA (File)</label>

                        <input type="file" name="keaktifan_simpatika_path" id="keaktifan_simpatika_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->keaktifan_simpatika_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->keaktifan_simpatika_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->keaktifan_simpatika_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Berkas S28a --}}
                    <div class="mb-3">
                        <label for="berkas_s28a_path" class="form-label">Berkas S28a (File)</label>

                        <input type="file" name="berkas_s28a_path" id="berkas_s28a_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->berkas_s28a_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->berkas_s28a_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->berkas_s28a_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Berkas SKMT --}}
                    <div class="mb-3">
                        <label for="berkas_skmt_path" class="form-label">Berkas SKMT (File)</label>

                        <input type="file" name="berkas_skmt_path" id="berkas_skmt_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->berkas_skmt_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->berkas_skmt_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->berkas_skmt_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Permohonan SKBK --}}
                    <div class="mb-3">
                        <label for="permohonan_skbk_path" class="form-label">Permohonan SKBK (File)</label>

                        <input type="file" name="permohonan_skbk_path" id="permohonan_skbk_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->permohonan_skbk_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->permohonan_skbk_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->permohonan_skbk_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Berkas SKBK --}}
                    <div class="mb-3">
                        <label for="berkas_skbk_path" class="form-label">Berkas SKBK (File)</label>

                        <input type="file" name="berkas_skbk_path" id="berkas_skbk_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->berkas_skbk_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->berkas_skbk_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->berkas_skbk_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- Sertifikat Pengembangan Diri --}}
                    <div class="mb-3">
                        <label for="sertifikat_pengembangan_diri_path" class="form-label">Sertifikat Pengembangan Diri (File)</label>

                        <input type="file" name="sertifikat_pengembangan_diri_path" id="sertifikat_pengembangan_diri_path" class="form-control"
                            accept=".pdf">

                        @if ($perSemester->sertifikat_pengembangan_diri_path)
                            <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                                <a href="{{ route('gdrive.preview', ['path' => $perSemester->sertifikat_pengembangan_diri_path]) }}"
                                    target="_blank" class="text-primary text-decoration-underline">
                                    Lihat File Lama
                                </a>
                                <span class="text-muted old-file-name">
                                    {{ basename($perSemester->sertifikat_pengembangan_diri_path) }}
                                </span>
                            </div>
                        @else
                            <p class="text-muted mt-1">Belum ada file</p>
                        @endif
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Kirim
                        </button>
                    </div>

                </div>
            </div>

        </form>

    </div>


    <style>
        .old-file-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 350px;
        }
    </style>

@endsection
