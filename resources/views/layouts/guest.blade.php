<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Connexion | Sozo Habitat</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/branding/sozo-habitat-emblem.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900">
    <div class="min-h-screen bg-[#F6F8FB] lg:grid lg:grid-cols-[1.05fr_0.95fr]">

        <aside class="relative hidden overflow-hidden bg-[#04152C] px-12 py-12 text-white lg:flex lg:flex-col lg:justify-between xl:px-20">
            <div
                class="pointer-events-none absolute inset-0 opacity-80"
                style="background:
                    radial-gradient(circle at 20% 18%, rgba(221,184,95,.20), transparent 23%),
                    radial-gradient(circle at 82% 75%, rgba(42,91,145,.35), transparent 30%);"
            ></div>

            <div class="relative z-10">
                <a href="/" class="inline-flex">
                    <img
                        src="{{ asset('images/branding/sozo-habitat-logo-dark.svg') }}"
                        alt="Sozo Habitat"
                        class="h-40 w-auto object-contain"
                    >
                </a>
            </div>

            <div class="relative z-10 max-w-xl pb-10">
                <p class="text-xs font-black uppercase tracking-[0.28em] text-[#DDB85F]">
                    Espace professionnel
                </p>

                <h1 class="mt-5 text-5xl font-black leading-[1.05] tracking-tight xl:text-6xl">
                    Pilotez l'activité
                    <span class="text-[#DDB85F]">Sozo Habitat.</span>
                </h1>

                <p class="mt-6 max-w-lg text-lg leading-8 text-slate-300">
                    Un accès réservé à l'équipe pour gérer les biens, les prospects, les visites et le suivi de l'activité.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-bold text-white/90">
                        Administration
                    </span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-bold text-white/90">
                        Agents
                    </span>
                </div>
            </div>

            <p class="relative z-10 text-xs text-slate-500">
                © {{ date('Y') }} Sozo Habitat · Accès sécurisé
            </p>
        </aside>

        <main class="relative flex min-h-screen items-center justify-center px-5 py-10 sm:px-8 lg:px-12">
            <a
                href="/"
                class="absolute left-5 top-5 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-[#0A2E5D] shadow-sm transition hover:-translate-y-0.5 hover:border-[#C89B3C] sm:left-8 sm:top-8"
            >
                <span aria-hidden="true">←</span>
                Retour au site
            </a>

            <div class="w-full max-w-lg">
                <div class="mb-8 flex items-center gap-3 lg:hidden">
                    <img
                        src="{{ asset('images/branding/sozo-habitat-emblem.svg') }}"
                        alt="Sozo Habitat"
                        class="h-12 w-12 object-contain"
                    >
                    <div>
                        <p class="text-xl font-black text-[#0A2E5D]">Sozo Habitat</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#C89B3C]">
                            Espace professionnel
                        </p>
                    </div>
                </div>

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>