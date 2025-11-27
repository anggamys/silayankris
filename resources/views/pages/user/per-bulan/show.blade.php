@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Berkas Per Bulan</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Periode:</strong> {{ $perBulan->periode ?? $perBulan->created_at->format('Y-m') }}</p>
                <p><strong>Daftar Gaji:</strong>
                    @if ($perBulan->daftar_gaji_path)
                        <a href="{{ asset('storage/' . $perBulan->daftar_gaji_path) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </p>
                <p><strong>Daftar Hadir:</strong>
                    @if ($perBulan->daftar_hadir_path)
                        <a href="{{ asset('storage/' . $perBulan->daftar_hadir_path) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </p>
                <p><strong>Rekening Bank:</strong>
                    @if ($perBulan->rekening_bank_path)
                        <a href="{{ asset('storage/' . $perBulan->rekening_bank_path) }}" target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

        <a href="{{ route('user.perbulan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection
