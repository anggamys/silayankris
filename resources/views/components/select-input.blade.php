@props([
    'id', // id unik untuk komponen
    'label', // label dropdown
    'name', // nama input hidden
    'options' => [], // array opsi
    'placeholder' => null, // placeholder tombol
    'disabled' => false, // disable dropdown
    'dropdownClass' => '', // custom class
    'buttonClass' => '', // custom class
    'ulClass' => '', // custom class
    'selected' => null, // value terpilih
    'searchable' => true, // dropdown searchable
])
<div class="dropdown {{ $dropdownClass }}">
	<button id="btn-{{ $id }}"
		class="btn btn-outline-secondary form-control text-start dropdown-toggle {{ $buttonClass }}" data-bs-toggle="dropdown"
		@if ($disabled) disabled @endif>
		{{ $selected ? $selected : $placeholder ?? 'Pilih ' . $label }}
	</button>
	<ul class="dropdown-menu w-100 {{ $ulClass }}" id="dropdown-{{ $id }}">
		@if ($searchable)
			<li class="px-2 py-1">
				<input type="text" class="form-control form-control-sm" placeholder="Cari {{ strtolower($label) }}..."
					id="search-{{ $id }}">
			</li>
			<li>
				<hr class="dropdown-divider">
			</li>
		@endif

		<div id="list-{{ $id }}" style="max-height:150px; overflow-y:auto;">

			@forelse($options as $key => $value)
				<li>
					<a class="dropdown-item py-1" data-value="{{ $key }}">
						{{ $value }}
					</a>
				</li>
			@empty
				<li><span class="dropdown-item-text text-muted">Tidak ada data</span></li>
			@endforelse
		</div>
	</ul>
	<input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $selected }}">
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {

		// Handle klik item
		function attachEventItems() {
			document.querySelectorAll("#list-{{ $id }} .dropdown-item").forEach(item => {
				item.addEventListener("click", function() {
					const value = this.getAttribute("data-value");
					document.getElementById("{{ $id }}").value = value;
					document.getElementById("btn-{{ $id }}").textContent = this
						.textContent;
				});
			});
		}

		attachEventItems(); // panggil awal

		// Search
		@if ($searchable)
			const searchInput = document.getElementById("search-{{ $id }}");

			searchInput.addEventListener("input", function() {
				const keyword = this.value.toLowerCase();

				// ambil ulang karena list bisa berubah saat AJAX
				const items = document.querySelectorAll("#list-{{ $id }} .dropdown-item");

				items.forEach(item => {
					const text = item.textContent.toLowerCase();
					item.style.display = text.includes(keyword) ? "" : "none";
				});
			});
		@endif
	});
</script>
