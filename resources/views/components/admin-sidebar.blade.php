<aside
    class="fixed inset-y-0 left-0 z-50 flex w-[min(86vw,20rem)] -translate-x-full flex-col overflow-y-auto bg-[#0A2E5D] p-5 text-white shadow-2xl transition-transform duration-300 ease-out lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:translate-x-0 lg:p-6 lg:shadow-none"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    aria-label="Navigation administration"
>
    <div class="mb-8 flex items-start justify-between gap-4 lg:mb-10">
        <div class="min-w-0 flex-1 text-center">
            @if($siteSettings && $siteSettings->logo)
                <img
                    src="{{ asset('images/settings/' . $siteSettings->logo) }}"
                    alt="{{ $siteSettings->site_name ?? 'Sozo Habitat' }}"
                    class="mx-auto mb-3 h-16 object-contain lg:h-20"
                >
            @else
                <div class="mb-3 text-xl font-black text-[#C89B3C] lg:text-2xl">
                    {{ $siteSettings->site_name ?? 'Sozo Habitat' }}
                </div>
            @endif

            <h2 class="text-xl font-black text-[#C89B3C] lg:text-2xl">
                SOZO ADMIN
            </h2>
        </div>

        <button
            type="button"
            @click="sidebarOpen = false"
            class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-white/15 bg-white/10 text-white lg:hidden"
            aria-label="Fermer le menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="space-y-2">
        <a
            href="{{ route('admin.dashboard') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.dashboard')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            📊 Dashboard
        </a>

        <a
            href="{{ route('admin.properties.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.properties.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            🏠 Biens
        </a>

        <a
            href="{{ route('admin.featured-properties.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.featured-properties.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            ⭐ Biens vedettes
        </a>

        <a
            href="{{ route('admin.property-inquiries.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.property-inquiries.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            📅 Demandes de visite
        </a>

        <a
            href="{{ route('admin.prospects.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.prospects.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            👤 Clients
        </a>

        <a
            href="{{ route('admin.users.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.users.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            👥 Utilisateurs
        </a>

        <a
            href="{{ route('admin.statistics.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.statistics.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            📈 Statistiques
        </a>

        <a
            href="{{ route('admin.site-settings.edit') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-4 py-3 transition
            {{ request()->routeIs('admin.site-settings.*')
                ? 'bg-white text-[#0A2E5D] font-black'
                : 'hover:bg-white/10' }}"
        >
            ⚙️ Paramètres du site
        </a>
    </nav>

    <div class="mt-auto pt-8">
        <div class="border-t border-white/10 pt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-red-600 py-3 font-bold transition hover:bg-red-700"
                >
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m-3-3h9m0 0l-3-3m3 3l-3 3" />
                        </svg>

                        Déconnexion
                    </span>
                </button>
            </form>
        </div>
    </div>
</aside>
