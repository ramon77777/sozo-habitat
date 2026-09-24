<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    @yield('seo')

    @if (!View::hasSection('seo'))
        <x-seo />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#04152C">

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/branding/sozo-habitat-emblem.svg') }}">
    <link rel="icon" type="image/webp" href="{{ asset('images/branding/sozo-habitat-logo.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/branding/sozo-habitat-logo.webp') }}">

    <title>
        @yield('title', 'SOZO Habitat | Immobilier en Côte d’Ivoire : Villas, Maisons et Terrains')
    </title>

    <meta name="description"
      content="@yield('description', 'SOZO Habitat vous accompagne dans vos projets immobiliers en Côte d’Ivoire : achat, vente et location de villas, maisons, appartements et terrains.')">

    <meta name="keywords"
      content="immobilier Côte d'Ivoire, maison à vendre Côte d'Ivoire, villa à vendre Côte d'Ivoire, terrain à vendre Côte d'Ivoire, location appartement Côte d'Ivoire, SOZO Habitat">

    <meta property="og:title"
      content="@yield('title', 'SOZO Habitat | Immobilier en Côte d’Ivoire')">

    <meta property="og:description"
      content="@yield('description', 'SOZO Habitat vous accompagne dans vos projets immobiliers en Côte d’Ivoire.')">

    <meta property="og:type" content="website">

    <meta property="og:image"
        content="{{ asset('images/branding/sozo-habitat-logo.webp') }}">

    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-x-hidden font-sans antialiased bg-[#F8F9FB] text-slate-900">

    @if(request()->is('admin*'))
        <div
            x-data="{ sidebarOpen: false }"
            @keydown.escape.window="sidebarOpen = false"
            class="min-h-screen lg:flex"
        >
            <div
                x-cloak
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-40 bg-slate-950/55 backdrop-blur-[2px] lg:hidden"
                @click="sidebarOpen = false"
                aria-hidden="true"
            ></div>

            <x-admin-sidebar />

            <div class="min-w-0 flex-1">
                <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 shadow-sm backdrop-blur lg:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-3">
                        <img
                            src="{{ asset('images/branding/sozo-habitat-emblem.svg') }}"
                            alt="Sozo Habitat"
                            class="h-9 w-9 shrink-0 object-contain"
                        >
                        <div class="min-w-0">
                            <p class="truncate text-sm font-black text-[#0A2E5D]">Sozo ADMIN</p>
                            <p class="truncate text-[10px] font-bold uppercase tracking-[0.16em] text-[#C89B3C]">Administration</p>
                        </div>
                    </a>

                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-[#0A2E5D] shadow-sm"
                        aria-label="Ouvrir le menu d'administration"
                        :aria-expanded="sidebarOpen.toString()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </header>

                <main class="min-w-0 overflow-x-hidden">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </main>
            </div>
        </div>
    @else
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    @endif

</body>
</html>
