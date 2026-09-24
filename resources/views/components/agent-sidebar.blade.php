<aside
    class="fixed inset-y-0 left-0 z-50 flex w-[min(86vw,20rem)] -translate-x-full flex-col overflow-y-auto bg-[#0A2E5D] p-5 text-white shadow-2xl transition-transform duration-300 ease-out lg:sticky lg:top-0 lg:h-screen lg:w-72 lg:translate-x-0 lg:p-6 lg:shadow-none"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    aria-label="Navigation agent"
>
    <div class="mb-8 flex items-start justify-between gap-4 lg:mb-10">
        <div class="min-w-0 flex-1 text-center">
            <img
                src="{{ asset('images/branding/sozo-habitat-emblem.svg') }}"
                alt="Sozo Habitat"
                class="mx-auto h-14 w-14 object-contain lg:h-16 lg:w-16"
            >

            <div class="mt-3 text-2xl font-black text-[#C89B3C] lg:text-3xl">
                SOZO
            </div>

            <div class="mt-1 text-sm text-white/70">
                Espace Agent
            </div>
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
        <a href="{{ route('agent.dashboard') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-5 py-3 transition
            {{ request()->routeIs('agent.dashboard')
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('agent.properties.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-5 py-3 transition
            {{ request()->routeIs('agent.properties.*')
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">
            🏠 Mes biens
        </a>

        <a href="{{ route('agent.prospects.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-5 py-3 transition
            {{ request()->routeIs('agent.prospects.*')
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">
            👤 Mes clients
        </a>

        <a href="{{ route('agent.appointments.index') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-5 py-3 transition
            {{ request()->routeIs('agent.appointments.*')
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">
            📅 Rendez-Vous
        </a>

        <a href="{{ route('profile.edit') }}"
            @click="sidebarOpen = false"
            class="block rounded-2xl px-5 py-3 transition
            {{ request()->routeIs('profile.*')
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">
            ⚙️ Mon profil
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
