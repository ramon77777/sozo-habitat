<div class="w-full max-w-6xl rounded-[1.8rem] border border-white/15 bg-white/10 p-3 shadow-[0_24px_70px_rgba(0,0,0,0.22)] backdrop-blur-xl sm:p-4">
    <form method="GET" action="{{ route('properties.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-4">
        <label class="group relative">
            <span class="sr-only">Ville</span>
            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 transition group-focus-within:text-[#C89B3C]">
                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                    <circle cx="12" cy="10" r="2.2"/>
                </svg>
            </span>

            <input
                type="text"
                name="city"
                placeholder="Ville ou commune"
                value="{{ request('city') }}"
                class="w-full rounded-2xl border-0 bg-white py-4 pl-12 pr-4 text-sm font-semibold text-slate-900 outline-none ring-1 ring-black/5 transition placeholder:font-medium placeholder:text-slate-400 focus:ring-2 focus:ring-[#C89B3C]"
            >
        </label>

        <label>
            <span class="sr-only">Transaction</span>
            <select
                name="transaction"
                class="w-full appearance-none rounded-2xl border-0 bg-white px-5 py-4 text-sm font-semibold text-slate-800 outline-none ring-1 ring-black/5 transition focus:ring-2 focus:ring-[#C89B3C]"
            >
                <option value="">Achat ou location</option>
                <option value="vente" @selected(request('transaction') === 'vente')>Acheter</option>
                <option value="location" @selected(request('transaction') === 'location')>Louer</option>
            </select>
        </label>

        <label>
            <span class="sr-only">Type de bien</span>
            <select
                name="type"
                class="w-full appearance-none rounded-2xl border-0 bg-white px-5 py-4 text-sm font-semibold text-slate-800 outline-none ring-1 ring-black/5 transition focus:ring-2 focus:ring-[#C89B3C]"
            >
                <option value="">Type de bien</option>
                <option value="villa" @selected(request('type') === 'villa')>Villa</option>
                <option value="duplex" @selected(request('type') === 'duplex')>Duplex</option>
                <option value="appartement" @selected(request('type') === 'appartement')>Appartement</option>
                <option value="maison_basse" @selected(request('type') === 'maison_basse')>Maison basse</option>
                <option value="terrain" @selected(request('type') === 'terrain')>Terrain</option>
            </select>
        </label>

        <button
            type="submit"
            class="sozo-shine inline-flex items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-6 py-4 text-sm font-black text-white shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
        >
            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="11" cy="11" r="6"/>
                <path stroke-linecap="round" d="m16 16 4 4"/>
            </svg>
            Rechercher
        </button>
    </form>
</div>