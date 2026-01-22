<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Simedan') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-900">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-brand-neutral bg-white/90 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- LEFT: BRAND + MENU --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="h-9 w-9 rounded-xl bg-brand-primary text-white flex items-center justify-center font-black">
                        ◎
                    </span>
                    <span class="font-black tracking-tight">SIMEDAN</span>
                </a>

                <a
                    href="{{ route('opportunities.index') }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold transition
                           {{ request()->routeIs('opportunities.*')
                                ? 'bg-brand-primary text-white'
                                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                >
                    Peluang Bisnis
                </a>
            </div>

            {{-- RIGHT: AUTH BUTTON --}}
            <div class="flex items-center gap-2">
                @auth
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center justify-center rounded-lg
                               border border-brand-neutral bg-white
                               px-4 py-2 text-sm font-semibold text-gray-700
                               hover:border-brand-primary/40 hover:text-gray-900 transition"
                    >
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg
                                   border border-brand-neutral bg-white
                                   px-4 py-2 text-sm font-semibold text-gray-700
                                   hover:border-brand-primary/40 hover:text-gray-900 transition"
                        >
                            Logout
                        </button>
                    </form>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center justify-center rounded-lg
                               bg-brand-cta px-4 py-2 text-sm font-semibold text-white
                               hover:bg-brand-cta/90 transition
                               focus:outline-none focus:ring-2 focus:ring-brand-cta/30"
                    >
                        Login Admin
                    </a>
                @endauth
            </div>

        </div>
    </header>

    {{-- CONTENT --}}
    <main class="py-6">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-brand-neutral bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-xs text-gray-500">
            © {{ date('Y') }} {{ config('app.name', 'Simedan') }}. All rights reserved.
        </div>
    </footer>

</body>
</html>
