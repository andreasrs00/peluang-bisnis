<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Simedan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-50">
            <div class="w-full max-w-md">
                <div class="flex items-center justify-center">
                    <a href="/" class="inline-flex items-center gap-3">
                        <span class="h-11 w-11 rounded-2xl bg-brand-primary text-white flex items-center justify-center font-black">
                            ◎
                        </span>
                        <span class="font-black tracking-tight text-lg text-gray-900">
                            {{ config('app.name', 'SIMEDAN') }}
                        </span>
                    </a>
                </div>

                <div class="mt-6 rounded-2xl border border-brand-neutral bg-white p-6 shadow-sm">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-xs text-gray-500">
                    © {{ date('Y') }} {{ config('app.name', 'Simedan') }}.
                </p>
            </div>
        </div>
    </body>
</html>
