<div class="w-full max-w-5xl rounded-2xl bg-white/15 p-4 backdrop-blur-xl shadow-2xl">
    <form method="GET" action="{{ route('properties.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input
            type="text"
            name="city"
            placeholder="Ville"
            value="{{ request('city') }}"
            class="rounded-xl bg-white px-5 py-4 text-sm text-slate-900 outline-none focus:ring-2 focus:ring-[#C89B3C]"
        >

        <select name="transaction" class="rounded-xl bg-white px-5 py-4 text-sm text-slate-900 outline-none focus:ring-2 focus:ring-[#C89B3C]">
            <option value="">Transaction</option>
            <option value="vente">Achat</option>
            <option value="location">Location</option>
        </select>

        <select name="type" class="rounded-xl bg-white px-5 py-4 text-sm text-slate-900 outline-none focus:ring-2 focus:ring-[#C89B3C]">
            <option value="">Type de bien</option>
            <option value="villa">Villa</option>
            <option value="duplex">Duplex</option>
            <option value="appartement">Appartement</option>
            <option value="maison_basse">Maison basse</option>
            <option value="terrain">Terrain</option>
        </select>

        <button
            type="submit"
            class="rounded-xl bg-[#C89B3C] px-6 py-4 text-sm font-bold text-white transition hover:bg-[#A87F2E]"
        >
            Rechercher
        </button>
    </form>
</div>