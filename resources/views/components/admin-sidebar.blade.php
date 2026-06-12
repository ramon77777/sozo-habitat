<aside class="w-72 bg-[#0A2E5D] text-white min-h-screen p-6">

    <div class="mb-10 text-center">

        @if($siteSettings && $siteSettings->logo)
            <img
                src="{{ asset('images/settings/' . $siteSettings->logo) }}"
                alt="{{ $siteSettings->site_name ?? 'Sozo Habitat' }}"
                class="h-20 mx-auto mb-4 object-contain"
            >
        @else
            <div class="text-2xl font-black text-[#C89B3C] mb-4">
                {{ $siteSettings->site_name ?? 'Sozo Habitat' }}
            </div>
        @endif

        <h2 class="text-2xl font-black text-[#C89B3C]">
            SOZO ADMIN
        </h2>

    </div>

    <nav class="space-y-2">

        <a
            href="{{ route('admin.dashboard') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.dashboard')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            📊 Dashboard
        </a>

        <a
            href="{{ route('admin.properties.index') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.properties.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            🏠 Biens
        </a>

        <a
            href="{{ route('admin.featured-properties.index') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.featured-properties.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            ⭐ Biens vedettes
        </a>

        <a
            href="{{ route('admin.property-inquiries.index') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.property-inquiries.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            📅 Demandes de visite
        </a>

        <a
            href="{{ route('admin.prospects.index') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.prospects.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            👤 Clients
        </a>

        <a
            href="{{ route('admin.users.index') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.users.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            👥 Utilisateurs
        </a>

        <a
            href="{{ route('admin.statistics.index') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.statistics.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            📈 Statistiques
        </a>

        <a
            href="{{ route('admin.site-settings.edit') }}"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.site-settings.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            ⚙️ Paramètres du site
        </a>

    </nav>

    <div class="mt-10 pt-6 border-t border-white/10">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="w-full rounded-2xl bg-red-600 py-3 font-bold hover:bg-red-700 transition"
            >
                <span class="flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m-3-3h9m0 0l-3-3m3 3l-3 3" />
                    </svg>

                    Déconnexion
                </span>
            </button>
        </form>

    </div>

</aside>