<aside class="w-72 bg-[#0A2E5D] text-white min-h-screen p-6">

    <div class="text-center mb-10">

        <div class="text-3xl font-black text-[#C89B3C]">
            SOZO
        </div>

        <div class="text-sm text-white/70 mt-2">
            Espace Agent
        </div>

    </div>


    <nav class="space-y-2">


        <a href="{{ route('agent.dashboard') }}"
            class="block px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('agent.dashboard') 
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">

            📊 Dashboard

        </a>




        <a href="{{ route('agent.properties.index') }}"
            class="block px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('agent.properties.*') 
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">

            🏠 Mes biens

        </a>





        <a href="{{ route('agent.prospects.index') }}"
            class="block px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('agent.prospects.*') 
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">

            👤 Mes clients

        </a>





        <a href="{{ route('agent.appointments.index') }}"
            class="block px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('agent.appointments.*') 
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">

            📅 Rendez-Vous

        </a>





        <a href="{{ route('profile.edit') }}"
            class="block px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('profile.*') 
            ? 'bg-white text-[#0A2E5D] font-bold'
            : 'hover:bg-white/10 text-white' }}">

            ⚙️ Mon profil

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