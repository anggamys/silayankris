<div class="bg-white rounded shadow p-6 w-full max-w-md mx-auto">
    @if (isset($title))
        <h2 class="text-2xl font-bold mb-6 text-center">{{ ucfirst($title) }}</h2>
    @endif

    {{ $slot }}
</div>
