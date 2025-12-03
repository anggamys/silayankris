@extends('layouts.appadmin')

@section('title', 'Manajemen Periode Per-bulan')

@section('breadcrumb')
	<li class="breadcrumb-item active">Data Periode Per-bulan</li>
@endsection

@section('content')
	<!-- Component Toast -->
	<x-toast />

	<div class="card shadow-sm border-0 mb-4 p-3">
		<div class="card-header bg-white border-0 mb-2">
			<h5 class="card-title fw-semibold">Daftar Data Periode Per-bulan</h5>

			<div class="row g-2 align-items-center">

				<!-- Search -->
				<div class="col-12 col-md-6">
					<form method="GET" class="w-100 d-flex align-items-center gap-2">
						{{-- 🔍 Input pencarian --}}
						<div class="input-group">
							<span class="input-group-text"><i class="bx bx-search"></i></span>
							<input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Cari...">
							<button class="btn btn-outline-secondary border" type="submit">Cari</button>
						</div>

						<a href="{{ url()->current() }}" class="btn btn-outline-secondary border d-flex align-items-center gap-1">
							<i class="bi bi-arrow-counterclockwise"></i>
							<span>Reset</span>
						</a>
					</form>
				</div>

				<!-- Button tambah -->
				<div class="col-12 col-md-auto ms-md-auto text-md-end">
					<a href="{{ route('admin.per-bulan.create') }}" class="btn btn-primary w-100 w-md-auto">
						<i class="bi bi-plus-lg me-1"></i> Tambah Baru
					</a>
				</div>
			</div>
		</div>

		<div class="card-body ">
			{{-- Tabel Periode Per-bulan --}}
			<div class="table-responsive text-nowrap">
				<table class="table table-hover">
					<thead class="">
						<tr class="text-start">
							<th>No</th>
							<th>Nama Pemilik</th>
							<th>Periode</th>
							<th>Tanggal Pengajuan</th>
							<th>Progress Upload</th>
							<th>Status</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse($perBulan as $item)
							<tr>
								@php
									// Cek kelengkapan file untuk progress bar
									$fields = [
									    $item->daftar_gaji_path,
									    $item->daftar_hadir_path,
									    $item->rekening_bank_path,
									    $item->ceklist_berkas,
									];
									$uploaded = collect($fields)->filter()->count();
									$filesTotal = 4;
									$progress = $filesTotal > 0 ? ($uploaded / $filesTotal) * 100 : 0;
								@endphp
								{{-- Make numbering continuous across pages using paginator firstItem() --}}
								<td>{{ optional($perBulan)->firstItem() ? $perBulan->firstItem() + $loop->index : $loop->iteration }}
								</td>

								{{-- Nama --}}
								<td>{{ $item->guru->user->name }}</td>

								{{-- PERIODE --}}
								<td>
									@if ($item->periode_per_bulan)
										{{ \Carbon\Carbon::parse($item->periode_per_bulan)->translatedFormat('F Y') }}
									@else
										-
									@endif
								</td>

								{{-- TANGGAL --}}
								<td>{{ $item->created_at->format('d M Y') }}</td>

								{{-- PROGRESS --}}
								<td style="min-width: 60px;">
									<div class="progress" style="height: 10px;">
										<div
											class="progress-bar 
                            @if ($progress == 100) bg-success
                            @elseif($progress >= 50) bg-warning
                            @else bg-danger @endif"
											style="width: {{ $progress }}%;"></div>
									</div>
									<small class="text-muted">{{ $uploaded }}/{{ $filesTotal }}</small>
								</td>

								{{-- Status --}}
								<td>
									@php
										$isIncomplete =
										    !$item->daftar_gaji_path ||
										    !$item->daftar_hadir_path ||
										    !$item->rekening_bank_path ||
										    !$item->ceklist_berkas;
									@endphp
									@if ($isIncomplete)
										<span class="badge bg-label-secondary">Belum Lengkap</span>
									@elseif($item->status == 'menunggu')
										<span class="badge bg-label-warning">Menunggu</span>
									@elseif($item->status == 'ditolak')
										<span class="badge bg-label-danger">Ditolak</span>
									@else
										<span class="badge bg-label-success">Diterima</span>
									@endif
								</td>

								<!-- Aksi -->
								<td>
									<div class="d-flex justify-content-center gap-2">
										<a href="{{ route('admin.per-bulan.show', $item) }}" class="btn btn-sm btn-info text-light">
											<i class="bx bx-info-circle"></i> Lihat
										</a>
										<a href="{{ route('admin.per-bulan.edit', $item) }}" class="btn btn-sm btn-warning text-light">
											<i class="bx bx-pencil"></i> Ubah
										</a>
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
											data-bs-target="#modalCenter{{ $item->id }}">
											<i class="bx bx-trash"></i> Hapus
										</button>

										<!-- Modal -->
										<div class="modal fade" id="modalCenter{{ $item->id }}" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="modalCenterTitle">Konfirmasi</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
														<p>
															Apakah anda yakin ingin menghapus <br>berkas milik
															<strong>{{ Str::limit($item->guru->user->name, 25, '...') }}</strong> ?
														</p>

														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
																Tidak
															</button>
															<form action="{{ route('admin.per-bulan.destroy', $item) }}" method="POST" onsubmit=" ">
																@csrf
																@method('DELETE')
																<button class="btn btn-danger">
																	<i class="bx bx-trash"></i> Hapus
																</button>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center text-muted py-4">
									<i class="bi bi-person-x fs-4 d-block mb-2"></i>
									Tidak ada data periode Per-bulan.
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			{{-- Pagination --}}
			<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
				<div class="small text-muted">
					Halaman <strong>{{ $currentPage }}</strong> dari <strong>{{ $lastPage }}</strong><br>
					Menampilkan <strong>{{ $perPage }}</strong> per halaman (total
					<strong>{{ $total }}</strong> periode Per-bulan)
					<div>
						{{ $perBulan->links() }}
					</div>
				</div>
			</div>
		</div>
	@endsection
