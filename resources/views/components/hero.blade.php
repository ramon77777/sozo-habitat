<section class="relative isolate min-h-[820px] overflow-hidden bg-[#04152C] lg:min-h-screen">
    <div
        data-hero-parallax
        class="absolute -inset-8 -z-30 bg-cover bg-center will-change-transform"
        style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c'); transform: scale(1.04);"
    ></div>

    <div class="absolute inset-0 -z-20 bg-gradient-to-r from-[#031329]/95 via-[#061A35]/78 to-[#061A35]/35"></div>
    <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_72%_35%,rgba(200,155,60,0.16),transparent_24rem)]"></div>
    <div class="absolute inset-x-0 bottom-0 -z-20 h-56 bg-gradient-to-t from-[#04152C]/70 to-transparent"></div>

    <div class="sozo-orb left-[8%] top-[22%] -z-10 h-28 w-28 border border-[#DDB85F]/25 bg-[#C89B3C]/10"></div>
    <div class="sozo-orb right-[10%] top-[30%] -z-10 h-40 w-40 border border-white/10 bg-white/5"></div>

    <x-navbar />

    <div class="mx-auto flex min-h-[820px] max-w-[1500px] items-center px-6 pb-24 pt-40 lg:min-h-screen lg:px-12">
        <div class="w-full">
            <div class="grid items-end gap-10 xl:grid-cols-[1fr_340px]">
                <div class="max-w-5xl">
                    <div class="hero-enter inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-black uppercase tracking-[0.24em] text-[#E3BD61] backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-[#C89B3C] shadow-[0_0_0_5px_rgba(200,155,60,0.12)]"></span>
                        La référence en immobilier
                    </div>

                    <h1 class="hero-enter hero-enter-delay-1 mt-7 max-w-5xl text-5xl font-black leading-[0.96] tracking-[-0.04em] text-white sm:text-6xl lg:text-7xl xl:text-[5.7rem]">
                        Un bien.
                        <span class="block text-[#D8A93B]">Un projet.</span>
                        <span class="block">Une nouvelle histoire.</span>
                    </h1>

                    <p class="hero-enter hero-enter-delay-2 mt-7 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Trouvez la maison, l'appartement ou le terrain qui correspond vraiment à votre projet,
                        avec un accompagnement immobilier pensé pour la Côte d'Ivoire.
                    </p>

                    <div class="hero-enter hero-enter-delay-3 mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('properties.index', ['transaction' => 'vente']) }}"
                            class="sozo-shine inline-flex items-center gap-2 rounded-full bg-[#C89B3C] px-6 py-3.5 text-sm font-black text-white shadow-xl shadow-black/15 transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
                        >
                            Explorer les biens
                            <span aria-hidden="true">→</span>
                        </a>

                        <a
                            href="/#contact"
                            class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-black text-white backdrop-blur transition hover:-translate-y-0.5 hover:bg-white hover:text-[#0A2E5D]"
                        >
                            Parler à notre équipe
                        </a>
                    </div>
                </div>

                <aside class="hero-enter hero-enter-delay-3 hidden rounded-[2rem] border border-white/15 bg-[#061A35]/45 p-6 text-white shadow-2xl shadow-black/15 backdrop-blur-xl xl:block">
                    <p class="text-[11px] font-black uppercase tracking-[0.22em] text-[#DDB85F]">
                        Votre recherche, simplement
                    </p>

                    <div class="mt-5 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#E0B34B]">01</span>
                            <div>
                                <p class="font-black">Cherchez</p>
                                <p class="mt-1 text-sm leading-6 text-slate-300">Par ville, type et transaction.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#E0B34B]">02</span>
                            <div>
                                <p class="font-black">Comparez</p>
                                <p class="mt-1 text-sm leading-6 text-slate-300">Prix, photos et caractéristiques.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/10 text-[#E0B34B]">03</span>
                            <div>
                                <p class="font-black">Visitez</p>
                                <p class="mt-1 text-sm leading-6 text-slate-300">Envoyez votre demande en ligne.</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="hero-enter hero-enter-delay-4 mt-10 lg:mt-12">
                <x-search-box />
            </div>

            <div class="hero-enter hero-enter-delay-4 mt-7 flex flex-wrap gap-x-8 gap-y-3 text-sm font-semibold text-white/75">
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
                <span class="inline-flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#C89B3C]"></span>
                    Accompagnement personnalisé
                </span>
            </div>
        </div>
    </div>

    <a href="#biens" class="sozo-scroll-cue absolute bottom-6 left-1/2 z-10 hidden -translate-x-1/2 flex-col items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-white/55 lg:flex">
        Découvrir
        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" d="m7 10 5 5 5-5"/>
        </svg>
    </a>
</section>