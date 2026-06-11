@extends('layouts.app')

@section('content')

<x-hero />

{{-- Pourquoi Sozo Habitat --}}
<section id="services" class="bg-white py-24 px-6">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-16">
            <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                Notre expertise
            </p>

            <h2 class="text-4xl md:text-5xl font-black text-[#0A2E5D] mt-4">
                Pourquoi choisir Sozo Habitat ?
            </h2>

            <p class="text-slate-500 mt-5 max-w-3xl mx-auto">
                Nous accompagnons particuliers, familles et investisseurs dans leurs projets immobiliers avec sérieux,
                transparence et proximité.
            </p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
            <div class="rounded-[2rem] bg-[#F8F9FB] p-8 shadow hover:shadow-xl transition">
                <div class="text-4xl mb-5">🏡</div>
                <h3 class="text-xl font-black text-[#0A2E5D]">Achat sécurisé</h3>
                <p class="text-slate-500 mt-4">
                    Des biens sélectionnés avec soin pour vous aider à investir avec confiance.
                </p>
            </div>

            <div class="rounded-[2rem] bg-[#F8F9FB] p-8 shadow hover:shadow-xl transition">
                <div class="text-4xl mb-5">🔑</div>
                <h3 class="text-xl font-black text-[#0A2E5D]">Location accompagnée</h3>
                <p class="text-slate-500 mt-4">
                    Nous vous aidons à trouver rapidement un logement adapté à votre budget.
                </p>
            </div>

            <div class="rounded-[2rem] bg-[#F8F9FB] p-8 shadow hover:shadow-xl transition">
                <div class="text-4xl mb-5">📍</div>
                <h3 class="text-xl font-black text-[#0A2E5D]">Terrains vérifiés</h3>
                <p class="text-slate-500 mt-4">
                    Des terrains bien localisés avec des informations claires sur les documents disponibles.
                </p>
            </div>

            <div class="rounded-[2rem] bg-[#F8F9FB] p-8 shadow hover:shadow-xl transition">
                <div class="text-4xl mb-5">🤝</div>
                <h3 class="text-xl font-black text-[#0A2E5D]">Suivi personnalisé</h3>
                <p class="text-slate-500 mt-4">
                    Une équipe disponible pour vous conseiller avant, pendant et après la visite.
                </p>
            </div>
        </div>

    </div>
</section>

{{-- Comment ça fonctionne --}}
<section class="bg-[#F8F9FB] py-24 px-6">
    <div class="max-w-7xl mx-auto">

        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Processus simple
                </p>

                <h2 class="text-4xl md:text-5xl font-black text-[#0A2E5D] mt-4">
                    Comment ça fonctionne ?
                </h2>

                <p class="text-slate-500 mt-5 max-w-xl">
                    Sozo Habitat simplifie votre recherche immobilière en vous guidant étape par étape.
                </p>
            </div>

            <div class="grid gap-5">
                <div class="rounded-3xl bg-white p-6 shadow flex gap-5">
                    <span class="h-12 w-12 rounded-full bg-[#C89B3C] text-white flex items-center justify-center font-black">1</span>
                    <div>
                        <h3 class="font-black text-[#0A2E5D] text-xl">Recherchez un bien</h3>
                        <p class="text-slate-500 mt-2">Filtrez par ville, transaction ou type de bien.</p>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow flex gap-5">
                    <span class="h-12 w-12 rounded-full bg-[#C89B3C] text-white flex items-center justify-center font-black">2</span>
                    <div>
                        <h3 class="font-black text-[#0A2E5D] text-xl">Consultez les détails</h3>
                        <p class="text-slate-500 mt-2">Photos, vidéos, localisation, prix et caractéristiques.</p>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow flex gap-5">
                    <span class="h-12 w-12 rounded-full bg-[#C89B3C] text-white flex items-center justify-center font-black">3</span>
                    <div>
                        <h3 class="font-black text-[#0A2E5D] text-xl">Demandez une visite</h3>
                        <p class="text-slate-500 mt-2">Contactez-nous par appel, WhatsApp ou formulaire.</p>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow flex gap-5">
                    <span class="h-12 w-12 rounded-full bg-[#C89B3C] text-white flex items-center justify-center font-black">4</span>
                    <div>
                        <h3 class="font-black text-[#0A2E5D] text-xl">Finalisez votre projet</h3>
                        <p class="text-slate-500 mt-2">Nous vous accompagnons jusqu’à la concrétisation.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Biens en vedette --}}
<section id="biens" class="bg-white py-24 px-6">
    <div class="max-w-[1600px] mx-auto">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8 mb-14">
            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Sélection premium
                </p>

                <h2 class="text-4xl md:text-5xl font-black text-[#0A2E5D] mt-4">
                    Nos biens en vedette
                </h2>

                <p class="text-slate-500 mt-4 max-w-2xl">
                    Découvrez une sélection de maisons, appartements et terrains soigneusement choisis par Sozo Habitat.
                </p>
            </div>

            <a href="{{ route('properties.index') }}"
               class="inline-flex items-center justify-center rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition">
                Voir tous les biens
            </a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-5 gap-8">
            @forelse($featuredProperties as $property)
                <article class="group bg-white rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition duration-300">
                    <div class="h-72 bg-slate-200 relative overflow-hidden">
                        <img
                            src="{{ asset('images/properties/'.$property->main_image) }}"
                            alt="{{ $property->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                        <span class="absolute top-5 left-5 bg-[#C89B3C] text-white px-4 py-2 rounded-full text-xs font-black uppercase tracking-wider">
                            {{ ucfirst($property->transaction) }}
                        </span>

                        <span class="absolute top-5 right-5 bg-white/90 text-[#0A2E5D] px-4 py-2 rounded-full text-xs font-black uppercase">
                            {{ ucfirst(str_replace('_', ' ', $property->type)) }}
                        </span>

                        <div class="absolute bottom-5 left-5 right-5">
                            <p class="text-white text-2xl font-black">
                                {{ number_format($property->price, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>

                    <div class="p-7">
                        <h3 class="text-2xl font-black text-[#0A2E5D] leading-tight">
                            {{ $property->title }}
                        </h3>

                        <p class="text-slate-500 mt-3">
                            {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                        </p>

                        <div class="grid grid-cols-3 gap-3 mt-6 text-center">
                            <div class="rounded-2xl bg-slate-50 p-3">
                                <p class="text-sm font-black text-[#0A2E5D]">{{ $property->surface ?? '-' }}</p>
                                <p class="text-xs text-slate-500">m²</p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-3">
                                <p class="text-sm font-black text-[#0A2E5D]">{{ $property->bedrooms ?? '-' }}</p>
                                <p class="text-xs text-slate-500">Chambres</p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-3">
                                <p class="text-sm font-black text-[#0A2E5D]">{{ $property->bathrooms ?? '-' }}</p>
                                <p class="text-xs text-slate-500">Bains</p>
                            </div>
                        </div>

                        <div class="mt-7 flex items-center justify-between">
                            <a href="{{ route('properties.show', $property) }}"
                               class="font-black text-[#0A2E5D] hover:text-[#C89B3C] transition">
                                Voir détails →
                            </a>

                            <a href="{{ route('properties.show', $property) }}"
                               class="h-10 w-10 rounded-full bg-[#0A2E5D] text-white flex items-center justify-center group-hover:bg-[#C89B3C] transition">
                                →
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl bg-[#F8F9FB] p-10 text-center text-slate-500">
                    Aucun bien en vedette pour le moment.
                </div>
            @endforelse
        </div>

    </div>
</section>

{{-- Footer premium --}}
<footer id="contact" class="bg-[#061A35] text-white px-6 py-16">
    <div class="max-w-7xl mx-auto">

        <div class="grid md:grid-cols-4 gap-10">

            {{-- Présentation --}}
            <div class="md:col-span-2">
                <h2 class="text-3xl font-black text-[#C89B3C]">
                    {{ $siteSettings->site_name ?? 'Sozo Habitat' }}
                </h2>

                <p class="mt-5 max-w-lg text-slate-300 leading-relaxed">
                    Sozo Habitat vous accompagne dans l’achat, la vente,
                    la location et la gestion immobilière partout en Côte d’Ivoire.
                </p>
            </div>

            {{-- Liens rapides --}}
            <div>
                <h3 class="font-black text-lg mb-5">
                    Liens rapides
                </h3>

                <div class="space-y-3 text-slate-300">

                    <a href="/" class="block hover:text-[#C89B3C] transition">
                        Accueil
                    </a>

                    <a href="{{ route('properties.index') }}" class="block hover:text-[#C89B3C] transition">
                        Biens
                    </a>

                    <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block hover:text-[#C89B3C] transition">
                        Acheter
                    </a>

                    <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block hover:text-[#C89B3C] transition">
                        Louer
                    </a>

                </div>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="font-black text-lg mb-5">
                    Contact
                </h3>

                <div class="space-y-4 text-slate-300">

                    @if($siteSettings->phone_1)
                        <a href="tel:+225{{ $siteSettings->phone_1 }}"
                           class="block hover:text-[#C89B3C] transition">
                            📞 {{ $siteSettings->phone_1 }}
                        </a>
                    @endif

                    @if($siteSettings->phone_2)
                        <a href="tel:+225{{ $siteSettings->phone_2 }}"
                           class="block hover:text-[#C89B3C] transition">
                            📞 {{ $siteSettings->phone_2 }}
                        </a>
                    @endif

                    @if($siteSettings->email)
                        <a href="mailto:{{ $siteSettings->email }}"
                           class="block hover:text-[#C89B3C] transition">
                            ✉️ {{ $siteSettings->email }}
                        </a>
                    @endif

                    @if($siteSettings->address)
                        <p>
                            📍 {{ $siteSettings->address }}
                        </p>
                    @endif

                    @if($siteSettings->whatsapp)
                        <a
                            href="https://wa.me/{{ $siteSettings->whatsapp }}"
                            target="_blank"
                            class="inline-flex mt-3 rounded-full bg-green-600 px-5 py-3 font-bold text-white hover:bg-green-700 transition"
                        >
                            WhatsApp
                        </a>
                    @endif

                </div>
            </div>

        </div>

        {{-- Réseaux sociaux --}}
        <div class="mt-12 flex flex-wrap gap-4">

            @if($siteSettings->facebook)
                <a href="{{ $siteSettings->facebook }}" target="_blank"
                   class="rounded-full border border-white/20 px-4 py-2 hover:bg-white hover:text-[#061A35] transition">
                    Facebook
                </a>
            @endif

            @if($siteSettings->instagram)
                <a href="{{ $siteSettings->instagram }}" target="_blank"
                   class="rounded-full border border-white/20 px-4 py-2 hover:bg-white hover:text-[#061A35] transition">
                    Instagram
                </a>
            @endif

            @if($siteSettings->linkedin)
                <a href="{{ $siteSettings->linkedin }}" target="_blank"
                   class="rounded-full border border-white/20 px-4 py-2 hover:bg-white hover:text-[#061A35] transition">
                    LinkedIn
                </a>
            @endif

            @if($siteSettings->tiktok)
                <a href="{{ $siteSettings->tiktok }}" target="_blank"
                   class="rounded-full border border-white/20 px-4 py-2 hover:bg-white hover:text-[#061A35] transition">
                    TikTok
                </a>
            @endif

            @if($siteSettings->youtube)
                <a href="{{ $siteSettings->youtube }}" target="_blank"
                   class="rounded-full border border-white/20 px-4 py-2 hover:bg-white hover:text-[#061A35] transition">
                    YouTube
                </a>
            @endif

        </div>

        {{-- Copyright --}}
        <div class="mt-14 border-t border-white/10 pt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 text-sm text-slate-400">

            <p>
                © {{ date('Y') }}
                {{ $siteSettings->site_name ?? 'Sozo Habitat' }}.
                Tous droits réservés.
            </p>

            <p>
                Immobilier premium en Côte d’Ivoire.
            </p>

        </div>

    </div>
</footer>
@endsection