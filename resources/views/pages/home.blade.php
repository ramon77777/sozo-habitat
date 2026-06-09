@extends('layouts.app')

@section('content')

<x-hero />

<section class="bg-[#F8F9FB] py-24 px-6">
    <div class="max-w-7xl mx-auto">

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

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($featuredProperties as $property)
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
                            {{ ucfirst($property->type) }}
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
            @endforeach
        </div>

    </div>
</section>

@endsection