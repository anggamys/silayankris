{{-- Card Component --}}
<div {{ $attributes->merge(['class' => 'bg-default text-foreground text-base flex flex-col gap-6 rounded-xl border py-6 shadow-sm']) }}
    data-slot="card">

    @if (isset($header))
        <div data-slot="card-header">
            {{ $header }}
        </div>
    @endif

    <div data-slot="card-content">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="flex items-center px-6" data-slot="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
