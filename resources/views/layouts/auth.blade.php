<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KEBAYAPAIS')</title>
    @vite('resources/css/app.css')
</head>

<body>

    <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10">
        <div class="flex w-full max-w-md flex-col gap-6">

            <a href="/" class="flex items-center gap-2 self-center font-medium">
                <div class="flex h-9 w-9 items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-9 object-contain" />
                </div>
                <div class="text-xl font-semibold">KEBAYAPAIS</div>
            </a>

            <div class="flex flex-col gap-6">
                <x-card class="px-5">
                    <x-slot name="header">
                        <div class="text-xl font-semibold">Login</div>
                        <div class=" text-sm">Masukkan email dan password untuk login</div>
                    </x-slot>

                    <div class="">
                        @yield('content')
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</body>

</html>
