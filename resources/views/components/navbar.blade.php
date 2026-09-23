<nav class="absolute inset-x-0 top-0 z-50 px-5 py-5 sm:px-8 lg:px-12">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between rounded-2xl border border-white/10 bg-[#061A35]/25 px-4 py-3 backdrop-blur-md sm:px-6">
        <a href="/" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#C89B3C] text-white shadow-lg shadow-black/10">
                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5 12 4l9 7.5M5.5 10v9.5h13V10M9.5 19.5v-5h5v5"/>
                </svg>
            </span>

            <span class="leading-none">
                <span class="block text-lg font-black tracking-tight text-white sm:text-xl">
                    {{ $siteSettings->site_name ?? 'Sozo Habitat' }}
                </span>
                <span class="mt-1 hidden text-[10px] font-bold uppercase tracking-[0.24em] text-[#DDB85F] sm:block">
                    Immobilier Côte d'Ivoire
                </span>
            </span>
        </a>

        <div class="hidden items-center gap-8 text-sm font-semibold text-white/90 md:flex">
            <a href="/" class="transition hover:text-[#DDB85F]">Accueil</a>
            <a href="{{ route('properties.index') }}" class="transition hover:text-[#DDB85F]">Biens</a>
            <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="transition hover:text-[#DDB85F]">Acheter</a>
            <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="transition hover:text-[#DDB85F]">Louer</a>
            <a href="/#contact" class="transition hover:text-[#DDB85F]">Contact</a>

            @auth
                <a
                    href="{{ auth()->user()->role === 'agent' ? route('agent.dashboard') : route('admin.dashboard') }}"
                    class="rounded-full bg-[#C89B3C] px-5 py-2.5 font-bold text-white transition hover:bg-[#B7892E]"
                >
                    Mon espace
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="rounded-full border border-white/30 bg-white/10 px-5 py-2.5 font-bold text-white transition hover:border-white hover:bg-white hover:text-[#0A2E5D]"
                >
                    Connexion
                </a>
            @endauth
        </div>

        <details class="relative md:hidden">
            <summary class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white [&::-webkit-details-marker]:hidden">
                <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </summary>

            <div class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-slate-200 bg-white p-3 text-[#0A2E5D] shadow-2xl">
                <a href="/" class="block rounded-xl px-4 py-3 font-bold hover:bg-slate-50">Accueil</a>
                <a href="{{ route('properties.index') }}" class="block rounded-xl px-4 py-3 font-bold hover:bg-slate-50">Biens</a>
                <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block rounded-xl px-4 py-3 font-bold hover:bg-slate-50">Acheter</a>
                <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block rounded-xl px-4 py-3 font-bold hover:bg-slate-50">Louer</a>
                <a href="/#contact" class="block rounded-xl px-4 py-3 font-bold hover:bg-slate-50">Contact</a>

                <div class="mt-2 border-t border-slate-100 pt-2">
                    @auth
                        <a
                            href="{{ auth()->user()->role === 'agent' ? route('agent.dashboard') : route('admin.dashboard') }}"
                            class="block rounded-xl bg-[#0A2E5D] px-4 py-3 text-center font-bold text-white"
                        >
                            Mon espace
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="block rounded-xl bg-[#0A2E5D] px-4 py-3 text-center font-bold text-white"
                        >
                            Connexion
                        </a>
                    @endauth
                </div>
            </div>
        </details>
    </div>
</nav>