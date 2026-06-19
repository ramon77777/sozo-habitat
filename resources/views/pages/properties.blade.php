@extends('layouts.app')

@section('seo')

<x-seo

    title="Biens immobiliers à vendre et à louer en Côte d'Ivoire | Sozo Habitat"

    description="Découvrez les maisons, villas, duplex, appartements et terrains disponibles à la vente ou à la location partout en Côte d'Ivoire avec Sozo Habitat."

    image="{{ asset('images/logo.png') }}"

/>

@endsection

@section('content')

<section class="bg-[#F8F9FB] min-h-screen py-16 px-6">
    <div class="max-w-7xl mx-auto">

        <div class="mb-10">
            <a href="/" class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">
                ← Retour à l'accueil
            </a>

            <h1 class="text-5xl font-black text-[#0A2E5D] mt-6">
                Tous nos biens
            </h1>

            <p class="text-slate-500 mt-3">
                Recherchez une maison, un appartement ou un terrain selon vos critères.
            </p>
        </div>

        <form method="GET" action="{{ route('properties.index') }}"
              class="bg-white rounded-3xl shadow-xl p-6 mb-12 grid md:grid-cols-5 gap-4">

            <select name="transaction" class="rounded-xl border border-slate-200 px-4 py-3">
                <option value="">Transaction</option>
                <option value="vente" @selected(request('transaction') === 'vente')>Vente</option>
                <option value="location" @selected(request('transaction') === 'location')>Location</option>
            </select>

            <select name="type" class="rounded-xl border border-slate-200 px-4 py-3">
                <option value="">Type</option>
                <option value="maison" @selected(request('type') === 'maison')>Maison</option>
                <option value="appartement" @selected(request('type') === 'appartement')>Appartement</option>
                <option value="terrain" @selected(request('type') === 'terrain')>Terrain</option>
            </select>

            <input name="city" value="{{ request('city') }}" placeholder="Ville"
                   class="rounded-xl border border-slate-200 px-4 py-3">

            <input name="min_price" value="{{ request('min_price') }}" placeholder="Prix min"
                   class="rounded-xl border border-slate-200 px-4 py-3">

            <input name="max_price" value="{{ request('max_price') }}" placeholder="Prix max"
                   class="rounded-xl border border-slate-200 px-4 py-3">

            <button class="md:col-span-5 rounded-xl bg-[#C89B3C] py-4 font-black text-white hover:bg-[#A87F2E] transition">
                Rechercher
            </button>
        </form>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($properties as $property)
                <article class="group bg-white rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition duration-300">
                    <div class="h-72 relative overflow-hidden">
                        <img
                            src="{{ asset('images/properties/'.$property->main_image) }}"
                            alt="{{ $property->city }} - Sozo Habitat Côte d'Ivoire"
                            loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                        <span class="absolute top-5 left-5 bg-[#C89B3C] text-white px-4 py-2 rounded-full text-xs font-black uppercase">
                            {{ ucfirst($property->transaction) }}
                        </span>

                        <p class="absolute bottom-5 left-5 text-white text-2xl font-black">
                            {{ number_format($property->price, 0, ',', ' ') }} FCFA
                        </p>
                    </div>

                    <div class="p-7">
                        <h3 class="text-2xl font-black text-[#0A2E5D]">
                            {{ $property->title }}
                        </h3>

                        <p class="text-slate-500 mt-3">
                            {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                        </p>

                        <a href="{{ route('properties.show', $property) }}"
                           class="inline-block mt-6 font-black text-[#0A2E5D] hover:text-[#C89B3C]">
                            Voir détails →
                        </a>
                    </div>
                </article>
            @empty
                <div class="md:col-span-3 bg-white rounded-3xl p-10 text-center shadow">
                    <h2 class="text-2xl font-black text-[#0A2E5D]">
                        Aucun bien trouvé
                    </h2>
                    <p class="text-slate-500 mt-2">
                        Essayez avec d'autres critères de recherche.
                    </p>
                </div>
            @endforelse
        </div>

    </div>
</section>

<div class="mb-10 text-center max-w-4xl mx-auto">

    <h1 class="text-4xl font-black text-[#0A2E5D]">
        Biens immobiliers en Côte d'Ivoire
    </h1>

    <p class="mt-4 text-slate-600 leading-relaxed">
        Sozo Habitat vous propose des biens immobiliers dans plusieurs villes de Côte d'Ivoire :
        Abidjan, Bouaké, Yamoussoukro, San Pedro, Korhogo et autres localités.
        Retrouvez des villas, maisons, duplex, appartements et terrains adaptés à vos projets.
    </p>

</div>

@endsection