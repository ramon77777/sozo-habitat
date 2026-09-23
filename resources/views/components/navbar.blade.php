<nav class="sozo-public-navbar fixed inset-x-0 top-0 z-50 px-3 py-3 sm:px-6 sm:py-4 lg:px-10">
    <div
        data-public-nav
        class="sozo-public-navbar-inner mx-auto flex max-w-[1500px] items-center justify-between rounded-2xl border border-white/10 bg-[#061A35]/30 px-3.5 py-2.5 backdrop-blur-xl sm:px-6 sm:py-3"
    >
        <a href="/" class="sozo-public-navbar-brand group flex min-w-0 items-center gap-2 sm:gap-3">
            <span class="sozo-public-navbar-emblem-wrap flex h-10 w-10 shrink-0 items-center justify-center transition duration-300 group-hover:scale-105 sm:h-12 sm:w-12">
                <img
                    src="{{ asset('images/branding/sozo-habitat-emblem-dark.svg') }}"
                    alt="Emblème Sozo Habitat"
                    class="sozo-public-navbar-emblem h-10 w-10 object-contain drop-shadow-[0_6px_16px_rgba(0,0,0,0.22)] sm:h-12 sm:w-12"
                >
            </span>

            <span class="sozo-public-navbar-copy min-w-0 leading-none">
                <span class="sozo-public-navbar-name block truncate text-base font-black tracking-tight text-white sm:text-xl">
                    {{ $siteSettings->site_name ?? 'Sozo Habitat' }}
                </span>
                <span class="sozo-public-navbar-tagline mt-1 hidden text-[10px] font-bold uppercase tracking-[0.24em] text-[#DDB85F] sm:block">
                    Immobilier Côte d'Ivoire
                </span>
            </span>
        </a>

        <div class="hidden items-center gap-7 text-sm font-semibold text-white/90 md:flex">
            <a href="/" class="relative py-2 transition hover:text-[#DDB85F]">Accueil</a>
            <a href="{{ route('properties.index') }}" class="relative py-2 transition hover:text-[#DDB85F]">Biens</a>
            <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="relative py-2 transition hover:text-[#DDB85F]">Acheter</a>
            <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="relative py-2 transition hover:text-[#DDB85F]">Louer</a>
            <a href="/#contact" class="relative py-2 transition hover:text-[#DDB85F]">Contact</a>
        </div>

        <details class="sozo-public-navbar-menu relative md:hidden">
            <summary class="sozo-public-navbar-menu-button flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-xl border border-white/20 bg-white/10 text-white transition hover:bg-white/20 sm:h-11 sm:w-11 [&::-webkit-details-marker]:hidden">
                <svg viewBox="0 0 24 24" fill="none" class="sozo-public-nav-toggle-icon h-6 w-6" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </summary>

            <div class="sozo-public-navbar-dropdown absolute right-0 mt-3 w-[min(16rem,calc(100vw-1.5rem))] overflow-hidden rounded-2xl border border-slate-200 bg-white p-2.5 text-[#0A2E5D] shadow-2xl sm:p-3">
                <a href="/" class="block rounded-xl px-4 py-3 font-bold transition hover:bg-slate-50">Accueil</a>
                <a href="{{ route('properties.index') }}" class="block rounded-xl px-4 py-3 font-bold transition hover:bg-slate-50">Biens</a>
                <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block rounded-xl px-4 py-3 font-bold transition hover:bg-slate-50">Acheter</a>
                <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block rounded-xl px-4 py-3 font-bold transition hover:bg-slate-50">Louer</a>
                <a href="/#contact" class="block rounded-xl px-4 py-3 font-bold transition hover:bg-slate-50">Contact</a>
            </div>
        </details>
    </div>
</nav>