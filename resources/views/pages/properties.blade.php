@extends('layouts.app')

@section('seo')
<x-seo
    title="Biens immobiliers à vendre et à louer en Côte d'Ivoire | Sozo Habitat"
    description="Découvrez les maisons, villas, duplex, appartements et terrains disponibles à la vente ou à la location partout en Côte d'Ivoire avec Sozo Habitat."
    image="{{ asset('images/branding/sozo-habitat-logo.webp') }}"
/>
@endsection

@section('content')

{{-- En-tête catalogue --}}
<section class="sozo-catalog-hero relative isolate overflow-hidden bg-[#04152C] px-4 pb-20 pt-32 text-white sm:px-6 sm:pb-28 sm:pt-40 lg:pb-36 lg:pt-44">
    <div class="absolute inset-0 -z-30 bg-[radial-gradient(circle_at_78%_25%,rgba(200,155,60,0.18),transparent_26rem)]"></div>
    <div class="absolute inset-0 -z-30 sozo-grid opacity-[0.07]"></div>
    <div class="absolute -left-24 top-28 -z-20 h-72 w-72 rounded-full border border-white/10"></div>
    <div class="absolute -right-20 bottom-0 -z-20 h-80 w-80 rounded-full bg-[#C89B3C]/10 blur-3xl"></div>

    <x-navbar />

    <div class="sozo-catalog-hero-inner mx-auto max-w-[1400px]">
        <div class="max-w-4xl" data-reveal>
            <a href="/" class="inline-flex items-center gap-2 text-sm font-bold text-white/65 transition hover:text-[#DDB85F]">
                <span aria-hidden="true">←</span>
                Retour à l'accueil
            </a>

            <div class="mt-6 inline-flex items-center gap-2.5 text-[10px] font-black uppercase tracking-[0.22em] text-[#DDB85F] sm:mt-8 sm:gap-3 sm:text-xs sm:tracking-[0.28em]">
                <span class="h-px w-8 bg-[#DDB85F]"></span>
                Notre catalogue
            </div>

            <h1 class="sozo-catalog-hero-title mt-4 max-w-4xl text-[2.55rem] font-black leading-[0.98] tracking-[-0.04em] sm:mt-5 sm:text-6xl lg:text-7xl">
                Trouvez le bien qui correspond à
                <span class="text-[#D8A93B]">votre projet.</span>
            </h1>

            <p class="sozo-catalog-hero-copy mt-5 max-w-2xl text-sm leading-6 text-slate-300 sm:mt-6 sm:text-lg sm:leading-8">
                Parcourez nos biens à vendre et à louer en Côte d'Ivoire, puis affinez votre recherche selon la ville,
                le type de bien et votre budget.
            </p>
        </div>
    </div>
</section>

{{-- Filtres --}}
@php
    $catalogFilterKeys = ['transaction', 'type', 'city', 'min_price', 'max_price', 'sort'];
    $activeFilterCount = collect($catalogFilterKeys)
        ->filter(fn ($key) => filled(request($key)))
        ->count();
    $hasActiveFilters = $activeFilterCount > 0;
@endphp

<section class="sozo-catalog-filter-section relative z-20 -mt-10 px-4 sm:-mt-16 sm:px-6">
    <div class="mx-auto max-w-[1400px]" data-reveal>
        <form
            method="GET"
            action="{{ route('properties.index') }}"
            x-data="catalogFilters({{ $hasActiveFilters ? 'true' : 'false' }})"
            class="rounded-[2rem] border border-white/70 bg-white p-4 shadow-[0_24px_70px_rgba(4,21,44,0.14)] sm:p-6"
        >
            {{-- Déclencheur mobile --}}
            <div class="md:hidden">
                <button
                    type="button"
                    @click="toggle()"
                    :aria-expanded="open.toString()"
                    aria-controls="catalog-filter-panel"
                    class="flex w-full items-center justify-between gap-4 rounded-[1.35rem] bg-[#F7F8FA] px-4 py-4 text-left transition hover:bg-slate-100"
                >
                    <span class="min-w-0">
                        <span class="block text-[10px] font-black uppercase tracking-[0.2em] text-[#C89B3C]">
                            Recherche avancée
                        </span>

                        <span class="mt-1 flex items-center gap-2 text-lg font-black text-[#0A2E5D]">
                            Affiner la recherche

                            @if($hasActiveFilters)
                                <span class="inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-[#C89B3C] px-2 text-[11px] font-black text-white">
                                    {{ $activeFilterCount }}
                                </span>
                            @endif
                        </span>
                    </span>

                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#0A2E5D] shadow-sm">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            class="h-5 w-5 transition duration-200"
                            :class="{ 'rotate-180': open }"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </button>
            </div>

            <div
                id="catalog-filter-panel"
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="mt-3 md:mt-0"
            >
                {{-- En-tête desktop --}}
                <div class="hidden border-b border-slate-100 pb-5 md:flex md:items-center md:justify-between md:gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-[#C89B3C]">Recherche avancée</p>
                        <h2 class="mt-1 text-xl font-black text-[#0A2E5D]">Affinez votre sélection</h2>
                    </div>

                    @if($hasActiveFilters)
                        <a
                            href="{{ route('properties.index') }}"
                            class="inline-flex items-center gap-2 text-sm font-black text-slate-500 transition hover:text-[#C89B3C]"
                        >
                            Réinitialiser les filtres
                            <span aria-hidden="true">×</span>
                        </a>
                    @endif
                </div>

                @if($hasActiveFilters)
                    <div class="mb-3 flex justify-end md:hidden">
                        <a
                            href="{{ route('properties.index') }}"
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#FFF8E8] px-3 py-2 text-xs font-black text-[#9A7222]"
                        >
                            Réinitialiser
                            <span aria-hidden="true">×</span>
                        </a>
                    </div>
                @endif

                <div class="sozo-catalog-filter-grid grid gap-3 md:mt-5 sm:grid-cols-2 xl:grid-cols-6">
                    <label>
                        <span class="sr-only">Transaction</span>
                        <select
                            name="transaction"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
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
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                        >
                            <option value="">Type de bien</option>
                            <option value="villa" @selected(request('type') === 'villa')>Villa</option>
                            <option value="duplex" @selected(request('type') === 'duplex')>Duplex</option>
                            <option value="appartement" @selected(request('type') === 'appartement')>Appartement</option>
                            <option value="maison_basse" @selected(request('type') === 'maison_basse')>Maison basse</option>
                            <option value="terrain" @selected(request('type') === 'terrain')>Terrain</option>
                        </select>
                    </label>

                    <label class="sozo-filter-city relative">
                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                <circle cx="12" cy="10" r="2.2"/>
                            </svg>
                        </span>

                        <span class="sr-only">Ville ou commune</span>
                        <input
                            type="text"
                            name="city"
                            value="{{ request('city') }}"
                            placeholder="Ville ou commune"
                            class="w-full rounded-2xl border border-slate-200 bg-white py-3.5 pl-10 pr-4 text-sm font-semibold text-slate-700 outline-none transition placeholder:font-medium placeholder:text-slate-400 focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                        >
                    </label>

                    <div class="sozo-filter-price grid grid-cols-2 gap-3 sm:contents">
                        <label>
                            <span class="sr-only">Prix minimum</span>
                            <input
                                type="number"
                                min="0"
                                name="min_price"
                                value="{{ request('min_price') }}"
                                placeholder="Prix min"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition placeholder:font-medium placeholder:text-slate-400 focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                            >
                        </label>

                        <label>
                            <span class="sr-only">Prix maximum</span>
                            <input
                                type="number"
                                min="0"
                                name="max_price"
                                value="{{ request('max_price') }}"
                                placeholder="Prix max"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition placeholder:font-medium placeholder:text-slate-400 focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                            >
                        </label>
                    </div>

                    <label class="sozo-filter-sort">
                        <span class="sr-only">Tri</span>
                        <select
                            name="sort"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                        >
                            <option value="">Plus récents</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Prix croissant</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Prix décroissant</option>
                        </select>
                    </label>
                </div>

                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="hidden text-sm text-slate-500 md:block">
                        Recherchez par ville ou commune et combinez plusieurs critères.
                    </p>

                    <button
                        type="submit"
                        class="sozo-shine inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-7 py-3.5 text-sm font-black text-white shadow-lg shadow-[#C89B3C]/20 transition hover:-translate-y-0.5 hover:bg-[#B7892E] sm:w-auto"
                    >
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="6"/>
                            <path stroke-linecap="round" d="m16 16 4 4"/>
                        </svg>
                        Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

{{-- Résultats --}}
<section class="sozo-catalog-results relative overflow-hidden bg-[#F7F8FA] px-4 pb-12 pt-12 sm:px-6 sm:pb-14 sm:pt-16 lg:pb-20 lg:pt-20">
    <div class="pointer-events-none absolute inset-0 sozo-grid opacity-35 [mask-image:linear-gradient(to_bottom,black,transparent_35%)]"></div>

    <div class="relative mx-auto max-w-[1400px]">
        <div class="mb-7 flex flex-col gap-3 sm:mb-9 sm:gap-4 sm:flex-row sm:items-end sm:justify-between" data-reveal>
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-[#C89B3C]">Résultats</p>
                <h2 class="sozo-catalog-results-title mt-2 text-[1.75rem] font-black leading-tight tracking-tight text-[#0A2E5D] sm:text-4xl">
                    {{ $properties->total() }} bien{{ $properties->total() > 1 ? 's' : '' }} disponible{{ $properties->total() > 1 ? 's' : '' }}
                </h2>
            </div>

            <p class="sozo-catalog-results-copy max-w-xl text-sm leading-6 text-slate-500">
                Cliquez sur un bien pour consulter toutes les photos, les caractéristiques, la localisation et demander une visite.
            </p>
        </div>

        <div class="grid grid-cols-1 justify-items-center gap-5 sm:grid-cols-[repeat(auto-fit,minmax(290px,420px))] sm:gap-7">
            @forelse($properties as $property)
                <article
                    data-reveal
                    data-reveal-delay="{{ ($loop->index % 3) * 90 }}"
                    class="sozo-card group w-full max-w-[420px] overflow-hidden rounded-[1.7rem] border border-white bg-white shadow-[0_18px_55px_rgba(15,23,42,0.08)] sm:rounded-[2rem]"
                >
                    <a href="{{ route('properties.show', $property) }}" class="block h-full">
                        <div class="sozo-media relative h-[235px] bg-slate-100 sm:h-[300px]">
                            @if($property->main_image_url)
                                <img
                                    src="{{ $property->main_image_url }}"
                                    alt="{{ $property->title }} - {{ $property->city }} - Sozo Habitat Côte d'Ivoire"
                                    loading="lazy"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-sm font-bold text-slate-400">
                                    Photo bientôt disponible
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-[#04152C]/90 via-[#04152C]/10 to-transparent"></div>

                            <div class="absolute left-4 right-4 top-4 flex items-center justify-between gap-2 sm:left-5 sm:right-5 sm:top-5 sm:gap-3">
                                <span class="rounded-full bg-[#C89B3C] px-4 py-2 text-[11px] font-black uppercase tracking-wider text-white shadow-lg">
                                    {{ $property->transaction === 'vente' ? 'À vendre' : 'À louer' }}
                                </span>

                                <span class="rounded-full bg-white/95 px-4 py-2 text-[11px] font-black uppercase text-[#0A2E5D] shadow-lg">
                                    {{ ucfirst(str_replace('_', ' ', $property->type)) }}
                                </span>
                            </div>

                            <div class="absolute bottom-4 left-4 right-4 sm:bottom-5 sm:left-5 sm:right-5">
                                <p class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                                    {{ number_format($property->price, 0, ',', ' ') }}
                                    <span class="text-sm font-bold text-white/70">FCFA</span>
                                </p>
                            </div>
                        </div>

                        <div class="p-5 sm:p-7">
                            <h3 class="text-xl font-black leading-tight text-[#0A2E5D] sm:text-2xl">
                                {{ $property->title }}
                            </h3>

                            <p class="mt-3 flex items-center gap-2 text-sm font-semibold text-slate-500">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 shrink-0 text-[#C89B3C]" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                    <circle cx="12" cy="10" r="2.2"/>
                                </svg>
                                {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                            </p>

                            <div class="mt-5 grid grid-cols-3 divide-x divide-slate-100 rounded-2xl bg-[#F7F8FA] px-1.5 py-3.5 text-center sm:mt-6 sm:px-2 sm:py-4">
                                <div class="px-2">
                                    <p class="text-base font-black text-[#0A2E5D]">{{ $property->surface ?? '-' }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">m²</p>
                                </div>

                                <div class="px-2">
                                    <p class="text-base font-black text-[#0A2E5D]">
                                        {{ $property->type === 'terrain' ? 'Terrain' : ($property->bedrooms ?? '-') }}
                                    </p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">
                                        {{ $property->type === 'terrain' ? 'Type' : 'Chambres' }}
                                    </p>
                                </div>

                                <div class="px-2">
                                    <p class="text-base font-black text-[#0A2E5D]">
                                        @if($property->type === 'terrain')
                                            {{ $property->has_acd ? 'Oui' : '—' }}
                                        @else
                                            {{ $property->bathrooms ?? '-' }}
                                        @endif
                                    </p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">
                                        {{ $property->type === 'terrain' ? 'ACD' : 'Bains' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-between sm:mt-6">
                                <span class="text-sm font-black text-[#0A2E5D] transition group-hover:text-[#C89B3C]">
                                    Voir le bien
                                </span>

                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#0A2E5D] text-white transition duration-300 group-hover:rotate-[-8deg] group-hover:bg-[#C89B3C]">
                                    →
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-white p-10 text-center shadow-sm" data-reveal>
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F7F8FA] text-[#C89B3C]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-7 w-7" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="11" cy="11" r="6"/>
                            <path stroke-linecap="round" d="m16 16 4 4"/>
                        </svg>
                    </span>

                    <h2 class="mt-5 text-2xl font-black text-[#0A2E5D]">Aucun bien trouvé</h2>
                    <p class="mx-auto mt-2 max-w-lg text-slate-500">
                        Aucun bien ne correspond à ces critères pour le moment. Essayez d'élargir votre recherche.
                    </p>

                    <a
                        href="{{ route('properties.index') }}"
                        class="mt-6 inline-flex rounded-full bg-[#0A2E5D] px-6 py-3 text-sm font-black text-white transition hover:bg-[#C89B3C]"
                    >
                        Voir tous les biens
                    </a>
                </div>
            @endforelse
        </div>

        @if($properties->hasPages())
            <div class="mt-12" data-reveal>
                {{ $properties->links() }}
            </div>
        @endif
    </div>
</section>

{{-- Réassurance / contact --}}
<section class="relative overflow-hidden bg-white px-6 py-20">
    <div
        data-reveal
        class="mx-auto grid max-w-[1400px] gap-8 overflow-hidden rounded-[2.4rem] bg-gradient-to-br from-[#0A2E5D] via-[#061A35] to-[#031329] px-7 py-10 text-white shadow-[0_28px_80px_rgba(4,21,44,0.18)] sm:px-10 lg:grid-cols-[1fr_auto] lg:items-center lg:px-14 lg:py-14"
    >
        <div>
            <p class="text-xs font-black uppercase tracking-[0.26em] text-[#DDB85F]">Besoin d'aide pour choisir ?</p>
            <h2 class="mt-3 max-w-3xl text-3xl font-black tracking-tight sm:text-4xl">
                Dites-nous ce que vous recherchez.
            </h2>
            <p class="mt-4 max-w-2xl leading-7 text-slate-300">
                Notre équipe peut vous orienter vers les biens disponibles qui correspondent le mieux à votre projet.
            </p>
        </div>

        <div class="flex flex-wrap gap-3 lg:justify-end">
            @if($siteSettings->whatsapp)
                <a
                    href="https://wa.me/{{ $siteSettings->whatsapp }}"
                    target="_blank"
                    rel="noopener"
                    class="sozo-shine rounded-full bg-[#C89B3C] px-6 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
                >
                    Écrire sur WhatsApp
                </a>
            @endif

            <a
                href="/#contact"
                class="rounded-full border border-white/25 bg-white/10 px-6 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-white hover:text-[#0A2E5D]"
            >
                Nous contacter
            </a>
        </div>
    </div>
</section>

{{-- Footer --}}
<x-public-footer :site-settings="$siteSettings" />


@endsection
