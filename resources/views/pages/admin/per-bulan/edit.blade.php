@extends("layouts.appadmin")

@section("title", "Edit Data Periodik Perbulan")

@section("breadcrumb")
	<li class="breadcrumb-item"><a href="{{ route("admin.per-bulan.index") }}" class="text-decoration-none">Data Periodik
			Perbulan</a></li>
	<li class="breadcrumb-item active" aria-current="page">Ubah Data Periodik Perbulan</li>
@endsection

@section("content")
	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
			<h5 class="mb-0 fw-semibold fs-4">Ubah Data Periodik Perbulan</h5>

			<a href="{{ route("admin.per-bulan.index") }}" class="btn btn-secondary">
				<i class="bi bi-arrow-left"></i> Batal
			</a>
		</div>

		<div class="card-body">

			<form action="{{ route("admin.per-bulan.update", $perBulan->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method("PUT")

				{{-- Guru --}}
				<div class="mb-3">
					<label for="guru_id" class="form-label">Guru</label>
					<select name="guru_id" id="guru_id" class="form-select" required>
						<option value="" disabled>Pilih Guru</option>

						@foreach ($gurus as $guru)
							<option value="{{ $guru->id }}" {{ $guru->id == old("guru_id", $perBulan->guru_id) ? "selected" : "" }}>
								{{ $guru->user->name }}
							</option>
						@endforeach
					</select>
					@error("guru_id")
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				{{-- Daftar Gaji --}}
				<div class="mb-3">
					<label class="form-label">Daftar Gaji (File Lama)</label><br>
					@if ($perBulan->daftar_gaji_path)
						<a href="{{ route("gdrive.preview", ["path" => $perBulan->daftar_gaji_path]) }}" target="_blank"
							class="text-primary text-decoration-underline">
							Lihat File Lama
						</a>
					@else
						<span class="text-muted">Belum ada file</span>
					@endif

					<label for="daftar_gaji_path" class="form-label mt-2">Ganti File (Opsional)</label>
					<input type="file" name="daftar_gaji_path" id="daftar_gaji_path" class="form-control" accept=".pdf">
				</div>

				{{-- Daftar Hadir --}}
				<div class="mb-3">
					<label class="form-label">Daftar Hadir (File Lama)</label><br>
					@if ($perBulan->daftar_hadir_path)
						<a href="{{ route("gdrive.preview", ["path" => $perBulan->daftar_hadir_path]) }}" target="_blank"
							class="text-primary text-decoration-underline">
							Lihat File Lama
						</a>
					@else
						<span class="text-muted">Belum ada file</span>
					@endif

					<label for="daftar_hadir_path" class="form-label mt-2">Ganti File (Opsional)</label>
					<input type="file" name="daftar_hadir_path" id="daftar_hadir_path" class="form-control" accept=".pdf">
				</div>

				{{-- Rekening Bank --}}
				<div class="mb-3">
					<label class="form-label">Rekening Bank (File Lama)</label><br>
					@if ($perBulan->rekening_bank_path)
						<a href="{{ route("gdrive.preview", ["path" => $perBulan->rekening_bank_path]) }}" target="_blank"
							class="text-primary text-decoration-underline">
							Lihat File Lama
						</a>
					@else
						<span class="text-muted">Belum ada file</span>
					@endif

					<label for="rekening_bank_path" class="form-label mt-2">Ganti File (Opsional)</label>
					<input type="file" name="rekening_bank_path" id="rekening_bank_path" class="form-control" accept=".pdf">
				</div>

				{{-- Ceklist --}}
				<div class="mb-3">
					<label for="ceklist_berkas" class="form-label">Ceklist Berkas</label>
					<input type="text" name="ceklist_berkas" id="ceklist_berkas" class="form-control"
						value="{{ old("ceklist_berkas", $perBulan->ceklist_berkas) }}" required>
				</div>

				{{-- Status --}}
				<div class="mb-3">
					<label for="status" class="form-label">Status</label>
					<select name="status" id="status" class="form-select" required>
						<option value="menunggu" {{ old("status", $perBulan->status) == "menunggu" ? "selected" : "" }}>
							Menunggu
						</option>
						<option value="diterima" {{ old("status", $perBulan->status) == "diterima" ? "selected" : "" }}>
							Diterima
						</option>
						<option value="ditolak" {{ old("status", $perBulan->status) == "ditolak" ? "selected" : "" }}>
							Ditolak
						</option>
					</select>
				</div>

				{{-- Catatan --}}
				<div class="mb-3">
					<label for="catatan" class="form-label">Catatan</label>
					<input type="text" name="catatan" id="catatan" class="form-control"
						value="{{ old("catatan", $perBulan->catatan) }}">
				</div>

				<div class="d-flex justify-content-end mt-4">
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-save me-1"></i> Simpan
					</button>
				</div>
			</form>

		</div>
	</div>
@endsection
