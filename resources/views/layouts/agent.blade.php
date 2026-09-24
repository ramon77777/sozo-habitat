<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0A2E5D">

    <title>Sozo Habitat Agent</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="overflow-x-hidden bg-slate-100 font-sans antialiased text-slate-900">

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

    <x-agent-sidebar />

    <div class="min-w-0 flex-1">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/95 px-4 shadow-sm backdrop-blur lg:hidden">
            <a href="{{ route('agent.dashboard') }}" class="flex min-w-0 items-center gap-3">
                <img
                    src="{{ asset('images/branding/sozo-habitat-emblem.svg') }}"
                    alt="Sozo Habitat"
                    class="h-9 w-9 shrink-0 object-contain"
                >
                <div class="min-w-0">
                    <p class="truncate text-sm font-black text-[#0A2E5D]">Sozo Habitat</p>
                    <p class="truncate text-[10px] font-bold uppercase tracking-[0.16em] text-[#C89B3C]">Espace Agent</p>
                </div>
            </a>

            <button
                type="button"
                @click="sidebarOpen = true"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-[#0A2E5D] shadow-sm"
                aria-label="Ouvrir le menu agent"
                :aria-expanded="sidebarOpen.toString()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <main class="min-w-0 p-4 sm:p-6 lg:p-10">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
