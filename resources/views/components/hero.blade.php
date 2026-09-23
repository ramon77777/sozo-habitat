<section
    class="relative isolate min-h-[780px] overflow-hidden bg-cover bg-center lg:min-h-[88vh]"
    style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c');"
>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#031329]/95 via-[#061A35]/75 to-black/35"></div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-48 bg-gradient-to-t from-[#031329]/45 to-transparent"></div>

    <x-navbar />

    <div class="mx-auto flex min-h-[780px] max-w-[1500px] items-center px-6 pb-20 pt-36 lg:min-h-[88vh] lg:px-12">
        <div class="w-full">
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.24em] text-[#E3BD61] backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-[#C89B3C]"></span>
                    La référence en immobilier
                </div>

                <h1 class="mt-7 max-w-4xl text-5xl font-black leading-[0.98] tracking-tight text-white sm:text-6xl lg:text-7xl xl:text-[5.4rem]">
                    Trouvez un lieu qui
                    <span class="text-[#D6A83E]">vous ressemble.</span>
                </h1>

                <p class="mt-7 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                    Achetez, louez ou investissez en Côte d'Ivoire avec une sélection de biens claire,
                    accessible et accompagnée par Sozo Habitat.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a
                        href="{{ route('properties.index', ['transaction' => 'vente']) }}"
                        class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-black text-[#0A2E5D] transition hover:-translate-y-0.5 hover:bg-[#F7E8BE]"
                    >
                        Voir les biens à vendre
                    </a>

                    <a
                        href="{{ route('properties.index', ['transaction' => 'location']) }}"
                        class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-6 py-3 text-sm font-black text-white backdrop-blur transition hover:bg-white hover:text-[#0A2E5D]"
                    >
                        Voir les locations
                    </a>
                </div>
            </div>

            <div class="mt-10 lg:mt-12">
                <x-search-box />
            </div>

            <div class="mt-7 flex flex-wrap gap-x-8 gap-y-3 text-sm font-semibold text-white/75">
                <span class="inline-flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C89B3C]"></span>
                    Villas & maisons
                </span>
                <span class="inline-flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C89B3C]"></span>
                    Appartements
                </span>
                <span class="inline-flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C89B3C]"></span>
                    Terrains
                </span>
            </div>
        </div>
    </div>
</section>