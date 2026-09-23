@extends('layouts.app')

@section('seo')
<x-seo
    title="Biens immobiliers à vendre et à louer en Côte d'Ivoire | Sozo Habitat"
    description="Découvrez les maisons, villas, duplex, appartements et terrains disponibles à la vente ou à la location partout en Côte d'Ivoire avec Sozo Habitat."
    image="{{ asset('images/logo.png') }}"
/>
@endsection

@section('content')

{{-- En-tête catalogue --}}
<section class="relative isolate overflow-hidden bg-[#04152C] px-6 pb-28 pt-40 text-white lg:pb-36 lg:pt-44">
    <div class="absolute inset-0 -z-30 bg-[radial-gradient(circle_at_78%_25%,rgba(200,155,60,0.18),transparent_26rem)]"></div>
    <div class="absolute inset-0 -z-30 sozo-grid opacity-[0.07]"></div>
    <div class="absolute -left-24 top-28 -z-20 h-72 w-72 rounded-full border border-white/10"></div>
    <div class="absolute -right-20 bottom-0 -z-20 h-80 w-80 rounded-full bg-[#C89B3C]/10 blur-3xl"></div>

    <x-navbar />

    <div class="mx-auto max-w-[1400px]">
        <div class="max-w-4xl" data-reveal>
            <a href="/" class="inline-flex items-center gap-2 text-sm font-bold text-white/65 transition hover:text-[#DDB85F]">
                <span aria-hidden="true">←</span>
                Retour à l'accueil
            </a>

            <div class="mt-8 inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.28em] text-[#DDB85F]">
                <span class="h-px w-8 bg-[#DDB85F]"></span>
                Notre catalogue
            </div>

            <h1 class="mt-5 max-w-4xl text-5xl font-black leading-[0.98] tracking-[-0.04em] sm:text-6xl lg:text-7xl">
                Trouvez le bien qui correspond à
                <span class="text-[#D8A93B]">votre projet.</span>
            </h1>

            <p class="mt-6 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                Parcourez nos biens à vendre et à louer en Côte d'Ivoire, puis affinez votre recherche selon la ville,
                le type de bien et votre budget.
            </p>
        </div>
    </div>
</section>

{{-- Filtres --}}
<section class="relative z-20 -mt-16 px-6">
    <div class="mx-auto max-w-[1400px]" data-reveal>
        <form
            method="GET"
            action="{{ route('properties.index') }}"
            class="rounded-[2rem] border border-white/70 bg-white p-5 shadow-[0_24px_70px_rgba(4,21,44,0.14)] sm:p-6"
        >
            <div class="flex flex-col gap-3 border-b border-slate-100 pb-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-[#C89B3C]">Recherche avancée</p>
                    <h2 class="mt-1 text-xl font-black text-[#0A2E5D]">Affinez votre sélection</h2>
                </div>

                @if(request()->hasAny(['transaction', 'type', 'city', 'min_price', 'max_price', 'sort']))
                    <a
                        href="{{ route('properties.index') }}"
                        class="inline-flex items-center gap-2 text-sm font-black text-slate-500 transition hover:text-[#C89B3C]"
                    >
                        Réinitialiser les filtres
                        <span aria-hidden="true">×</span>
                    </a>
                @endif
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-6">
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

                <label class="relative">
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

                <label>
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
                <p class="text-sm text-slate-500">
                    Recherchez par ville ou commune et combinez plusieurs critères.
                </p>

                <button
                    type="submit"
                    class="sozo-shine inline-flex items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-7 py-3.5 text-sm font-black text-white shadow-lg shadow-[#C89B3C]/20 transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
                >
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="11" cy="11" r="6"/>
                        <path stroke-linecap="round" d="m16 16 4 4"/>
                    </svg>
                    Rechercher
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Résultats --}}
<section class="relative overflow-hidden bg-[#F7F8FA] px-6 pb-20 pt-16 lg:pb-28 lg:pt-20">
    <div class="pointer-events-none absolute inset-0 sozo-grid opacity-35 [mask-image:linear-gradient(to_bottom,black,transparent_35%)]"></div>

    <div class="relative mx-auto max-w-[1400px]">
        <div class="mb-9 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between" data-reveal>
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-[#C89B3C]">Résultats</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-[#0A2E5D] sm:text-4xl">
                    {{ $properties->total() }} bien{{ $properties->total() > 1 ? 's' : '' }} disponible{{ $properties->total() > 1 ? 's' : '' }}
                </h2>
            </div>

            <p class="max-w-xl text-sm leading-6 text-slate-500">
                Cliquez sur un bien pour consulter toutes les photos, les caractéristiques, la localisation et demander une visite.
            </p>
        </div>

        <div class="grid grid-cols-[repeat(auto-fit,minmax(290px,1fr))] gap-7 xl:grid-cols-3">
            @forelse($properties as $property)
                <article
                    data-reveal
                    data-reveal-delay="{{ ($loop->index % 3) * 90 }}"
                    class="sozo-card group overflow-hidden rounded-[2rem] border border-white bg-white shadow-[0_18px_55px_rgba(15,23,42,0.08)]"
                >
                    <a href="{{ route('properties.show', $property) }}" class="block h-full">
                        <div class="sozo-media relative h-[300px] bg-slate-100">
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

                            <div class="absolute left-5 right-5 top-5 flex items-center justify-between gap-3">
                                <span class="rounded-full bg-[#C89B3C] px-4 py-2 text-[11px] font-black uppercase tracking-wider text-white shadow-lg">
                                    {{ $property->transaction === 'vente' ? 'À vendre' : 'À louer' }}
                                </span>

                                <span class="rounded-full bg-white/95 px-4 py-2 text-[11px] font-black uppercase text-[#0A2E5D] shadow-lg">
                                    {{ ucfirst(str_replace('_', ' ', $property->type)) }}
                                </span>
                            </div>

                            <div class="absolute bottom-5 left-5 right-5">
                                <p class="text-3xl font-black tracking-tight text-white">
                                    {{ number_format($property->price, 0, ',', ' ') }}
                                    <span class="text-sm font-bold text-white/70">FCFA</span>
                                </p>
                            </div>
                        </div>

                        <div class="p-7">
                            <h3 class="text-2xl font-black leading-tight text-[#0A2E5D]">
                                {{ $property->title }}
                            </h3>

                            <p class="mt-3 flex items-center gap-2 text-sm font-semibold text-slate-500">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 shrink-0 text-[#C89B3C]" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                    <circle cx="12" cy="10" r="2.2"/>
                                </svg>
                                {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                            </p>

                            <div class="mt-6 grid grid-cols-3 divide-x divide-slate-100 rounded-2xl bg-[#F7F8FA] px-2 py-4 text-center">
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

                            <div class="mt-6 flex items-center justify-between">
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
<footer id="contact" class="bg-[#04152C] px-6 pb-8 pt-16 text-white">
    <div class="mx-auto max-w-[1400px]">
        <div class="grid gap-10 border-b border-white/10 pb-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#C89B3C]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5 12 4l9 7.5M5.5 10v9.5h13V10M9.5 19.5v-5h5v5"/>
                        </svg>
                    </span>

                    <div>
                        <h2 class="text-2xl font-black">{{ $siteSettings->site_name ?? 'Sozo Habitat' }}</h2>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#DDB85F]">La référence en immobilier</p>
                    </div>
                </div>

                <p class="mt-6 max-w-lg leading-7 text-slate-300">
                    Sozo Habitat vous accompagne dans l'achat, la vente et la location de biens immobiliers en Côte d'Ivoire.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @foreach([
                        ['Facebook', $siteSettings->facebook],
                        ['Instagram', $siteSettings->instagram],
                        ['LinkedIn', $siteSettings->linkedin],
                        ['TikTok', $siteSettings->tiktok],
                        ['YouTube', $siteSettings->youtube],
                    ] as [$label, $url])
                        @if($url)
                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener"
                                class="rounded-full border border-white/15 px-4 py-2 text-xs font-bold text-slate-300 transition hover:border-[#C89B3C] hover:text-[#DDB85F]"
                            >
                                {{ $label }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-black uppercase tracking-[0.18em] text-[#DDB85F]">Navigation</h3>
                <div class="mt-5 space-y-3 text-sm font-semibold text-slate-300">
                    <a href="/" class="block transition hover:translate-x-1 hover:text-white">Accueil</a>
                    <a href="{{ route('properties.index') }}" class="block transition hover:translate-x-1 hover:text-white">Tous les biens</a>
                    <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block transition hover:translate-x-1 hover:text-white">Acheter</a>
                    <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block transition hover:translate-x-1 hover:text-white">Louer</a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-black uppercase tracking-[0.18em] text-[#DDB85F]">Nous contacter</h3>

                <div class="mt-5 space-y-3 text-sm text-slate-300">
                    @if($siteSettings->phone_1)
                        <a href="tel:+225{{ $siteSettings->phone_1 }}" class="block transition hover:text-white">
                            {{ $siteSettings->phone_1 }}
                        </a>
                    @endif

                    @if($siteSettings->phone_2)
                        <a href="tel:+225{{ $siteSettings->phone_2 }}" class="block transition hover:text-white">
                            {{ $siteSettings->phone_2 }}
                        </a>
                    @endif

                    @if($siteSettings->email)
                        <a href="mailto:{{ $siteSettings->email }}" class="block break-all transition hover:text-white">
                            {{ $siteSettings->email }}
                        </a>
                    @endif

                    @if($siteSettings->address)
                        <p>{{ $siteSettings->address }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 pt-7 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ date('Y') }} {{ $siteSettings->site_name ?? 'Sozo Habitat' }}. Tous droits réservés.</p>
            <p>Immobilier en Côte d'Ivoire.</p>
        </div>
    </div>
</footer>

@if($siteSettings->whatsapp)
    <a
        href="https://wa.me/{{ $siteSettings->whatsapp }}"
        target="_blank"
        rel="noopener"
        class="sozo-whatsapp flex h-14 w-14 items-center justify-center rounded-full bg-green-500 text-white transition hover:-translate-y-1 hover:bg-green-600"
        aria-label="Contacter Sozo Habitat sur WhatsApp"
    >
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7" aria-hidden="true">
            <path d="M12.05 2a9.88 9.88 0 0 0-8.46 15.02L2.2 22l5.1-1.34A9.98 9.98 0 1 0 12.05 2Zm0 17.98a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.02.8.81-2.95-.2-.3A8.05 8.05 0 1 1 12.05 20Zm4.42-6.04c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.19-.71-.63-1.19-1.42-1.33-1.66-.14-.24-.02-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.19-.47-.39-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.1.16 1.51.1.46-.07 1.43-.58 1.63-1.15.2-.56.2-1.05.14-1.15-.06-.1-.22-.16-.46-.28Z"/>
        </svg>
    </a>
@endif

@endsection
