@extends('layouts.app')

@section('title')
SOZO Habitat | Immobilier en Côte d’Ivoire : Villas, Maisons et Terrains
@endsection

@section('description')
Découvrez des biens immobiliers en Côte d’Ivoire avec SOZO Habitat : villas, maisons, appartements et terrains à vendre ou à louer avec un accompagnement professionnel.
@endsection

@section('content')

<x-hero />

{{-- Biens en vedette --}}
<section id="biens" class="relative overflow-hidden bg-white px-6 py-20 lg:py-24">
    <div class="absolute -right-32 top-8 h-72 w-72 rounded-full bg-[#C89B3C]/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-[1500px]">
        <div class="mb-12 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.28em] text-[#C89B3C]">
                    <span class="h-px w-8 bg-[#C89B3C]"></span>
                    Sélection premium
                </div>

                <h2 class="mt-4 max-w-3xl text-4xl font-black tracking-tight text-[#0A2E5D] md:text-5xl">
                    Des biens choisis pour vos projets de vie.
                </h2>

                <p class="mt-4 max-w-2xl text-base leading-7 text-slate-500">
                    Découvrez nos opportunités actuellement mises en avant : résidences, appartements et terrains
                    sélectionnés avec soin en Côte d'Ivoire.
                </p>
            </div>

            <a
                href="{{ route('properties.index') }}"
                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full border border-[#0A2E5D]/20 bg-white px-6 py-3.5 text-sm font-black text-[#0A2E5D] shadow-sm transition hover:-translate-y-0.5 hover:border-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white"
            >
                Voir tous les biens
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="grid grid-cols-[repeat(auto-fit,minmax(270px,320px))] justify-center gap-7">
            @forelse($featuredProperties as $property)
                <article class="group overflow-hidden rounded-[1.75rem] border border-slate-100 bg-white shadow-[0_18px_50px_rgba(15,23,42,0.08)] transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_28px_70px_rgba(15,23,42,0.14)]">
                    <a href="{{ route('properties.show', $property) }}" class="block">
                        <div class="relative h-72 overflow-hidden bg-slate-100">
                            @if($property->main_image_url)
                                <img
                                    src="{{ $property->main_image_url }}"
                                    alt="{{ $property->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-sm font-bold text-slate-400">
                                    Photo bientôt disponible
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-[#061A35]/85 via-[#061A35]/10 to-transparent"></div>

                            <div class="absolute left-4 right-4 top-4 flex items-center justify-between gap-3">
                                <span class="rounded-full bg-[#C89B3C] px-3.5 py-2 text-[11px] font-black uppercase tracking-wider text-white shadow">
                                    {{ $property->transaction === 'vente' ? 'À vendre' : 'À louer' }}
                                </span>

                                <span class="rounded-full bg-white/95 px-3.5 py-2 text-[11px] font-black uppercase text-[#0A2E5D] shadow">
                                    {{ ucfirst(str_replace('_', ' ', $property->type)) }}
                                </span>
                            </div>

                            <div class="absolute bottom-5 left-5 right-5">
                                <p class="text-2xl font-black text-white">
                                    {{ number_format($property->price, 0, ',', ' ') }}
                                    <span class="text-sm font-bold text-white/80">FCFA</span>
                                </p>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-xl font-black leading-tight text-[#0A2E5D]">
                                        {{ $property->title }}
                                    </h3>

                                    <p class="mt-2 flex items-center gap-2 text-sm font-medium text-slate-500">
                                        <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 shrink-0 text-[#C89B3C]" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                            <circle cx="12" cy="10" r="2.2"/>
                                        </svg>
                                        {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-3 divide-x divide-slate-100 rounded-2xl bg-[#F8F9FB] px-2 py-4 text-center">
                                <div class="px-2">
                                    <p class="text-sm font-black text-[#0A2E5D]">{{ $property->surface ?? '-' }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">m²</p>
                                </div>

                                <div class="px-2">
                                    <p class="text-sm font-black text-[#0A2E5D]">{{ $property->type === 'terrain' ? '-' : ($property->bedrooms ?? '-') }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Chambres</p>
                                </div>

                                <div class="px-2">
                                    <p class="text-sm font-black text-[#0A2E5D]">{{ $property->type === 'terrain' ? '-' : ($property->bathrooms ?? '-') }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Bains</p>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-sm font-black text-[#0A2E5D] transition group-hover:text-[#C89B3C]">
                                    Découvrir ce bien
                                </span>

                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#0A2E5D] text-white transition group-hover:bg-[#C89B3C]">
                                    →
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-[#F8F9FB] p-12 text-center">
                    <h3 class="text-xl font-black text-[#0A2E5D]">Nos prochaines opportunités arrivent bientôt.</h3>
                    <p class="mt-2 text-slate-500">Consultez l'ensemble de nos biens disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Expertise --}}
<section id="services" class="bg-[#F7F8FA] px-6 py-20 lg:py-24">
    <div class="mx-auto max-w-[1400px]">
        <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:items-end">
            <div>
                <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.28em] text-[#C89B3C]">
                    <span class="h-px w-8 bg-[#C89B3C]"></span>
                    Notre expertise
                </div>

                <h2 class="mt-4 text-4xl font-black tracking-tight text-[#0A2E5D] md:text-5xl">
                    L'immobilier avec plus de clarté.
                </h2>

                <p class="mt-5 max-w-xl text-base leading-8 text-slate-500">
                    Sozo Habitat accompagne particuliers, familles et investisseurs avec une approche simple :
                    des informations lisibles, un suivi humain et des biens présentés avec soin.
                </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <article class="rounded-[1.75rem] border border-white bg-white p-7 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E2B64F]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                            <path stroke-linecap="round" d="M9 20v-5h6v5"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-black text-[#0A2E5D]">Biens sélectionnés</h3>
                    <p class="mt-2 leading-7 text-slate-500">Des annonces structurées et des caractéristiques faciles à comprendre.</p>
                </article>

                <article class="rounded-[1.75rem] border border-white bg-white p-7 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E2B64F]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12.5 11 15l4.8-5.2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 5 6v5c0 4.5 2.8 8.2 7 10 4.2-1.8 7-5.5 7-10V6l-7-3Z"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-black text-[#0A2E5D]">Projet accompagné</h3>
                    <p class="mt-2 leading-7 text-slate-500">Un interlocuteur pour vous guider de la recherche jusqu'à la visite.</p>
                </article>

                <article class="rounded-[1.75rem] border border-white bg-white p-7 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E2B64F]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                            <circle cx="12" cy="10" r="2.2"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-black text-[#0A2E5D]">Ancrage local</h3>
                    <p class="mt-2 leading-7 text-slate-500">Des opportunités immobilières dans différentes villes et communes de Côte d'Ivoire.</p>
                </article>

                <article class="rounded-[1.75rem] border border-white bg-white p-7 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E2B64F]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14v11H9l-4 3V5Z"/>
                            <path stroke-linecap="round" d="M8 9h8M8 12h5"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-black text-[#0A2E5D]">Réponse rapide</h3>
                    <p class="mt-2 leading-7 text-slate-500">Téléphone, WhatsApp ou formulaire : choisissez le canal qui vous convient.</p>
                </article>
            </div>
        </div>
    </div>
</section>

{{-- Processus --}}
<section class="bg-white px-6 py-20 lg:py-24">
    <div class="mx-auto max-w-[1400px]">
        <div class="mx-auto max-w-3xl text-center">
            <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.28em] text-[#C89B3C]">
                <span class="h-px w-8 bg-[#C89B3C]"></span>
                Processus simple
                <span class="h-px w-8 bg-[#C89B3C]"></span>
            </div>

            <h2 class="mt-4 text-4xl font-black tracking-tight text-[#0A2E5D] md:text-5xl">
                Votre projet en quatre étapes.
            </h2>

            <p class="mt-5 text-base leading-8 text-slate-500">
                De la première recherche à la prise de contact, tout est pensé pour vous faire gagner du temps.
            </p>
        </div>

        <div class="relative mt-14 grid gap-5 md:grid-cols-4">
            <div class="pointer-events-none absolute left-[12%] right-[12%] top-8 hidden h-px bg-slate-200 md:block"></div>

            @foreach([
                ['01', 'Recherchez', 'Filtrez par ville, type de bien et transaction.'],
                ['02', 'Comparez', 'Consultez photos, prix, surfaces et localisation.'],
                ['03', 'Planifiez', 'Envoyez une demande de visite en quelques secondes.'],
                ['04', 'Concrétisez', 'Échangez avec notre équipe pour avancer sereinement.'],
            ] as [$number, $title, $text])
                <article class="relative rounded-[1.75rem] border border-slate-100 bg-white p-6 text-center shadow-[0_12px_38px_rgba(15,23,42,0.06)]">
                    <span class="relative z-10 mx-auto flex h-16 w-16 items-center justify-center rounded-full border-8 border-white bg-[#0A2E5D] text-sm font-black text-[#E1B44B] shadow">
                        {{ $number }}
                    </span>

                    <h3 class="mt-5 text-lg font-black text-[#0A2E5D]">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-[#F7F8FA] px-6 py-20">
    <div class="mx-auto max-w-[1400px] overflow-hidden rounded-[2.25rem] bg-[#061A35] px-7 py-10 text-white shadow-2xl sm:px-10 lg:px-14 lg:py-14">
        <div class="grid gap-10 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.28em] text-[#DDB85F]">Un projet immobilier ?</p>
                <h2 class="mt-3 max-w-3xl text-3xl font-black tracking-tight sm:text-4xl">
                    Parlons de ce que vous recherchez.
                </h2>
                <p class="mt-4 max-w-2xl leading-7 text-slate-300">
                    Achat, location ou terrain : notre équipe est disponible pour vous orienter vers les opportunités adaptées.
                </p>
            </div>

            <div class="flex flex-wrap gap-3 lg:justify-end">
                @if($siteSettings->whatsapp)
                    <a
                        href="https://wa.me/{{ $siteSettings->whatsapp }}"
                        target="_blank"
                        rel="noopener"
                        class="rounded-full bg-[#C89B3C] px-6 py-3.5 text-sm font-black text-white transition hover:bg-[#B7892E]"
                    >
                        Écrire sur WhatsApp
                    </a>
                @endif

                <a
                    href="{{ route('properties.index') }}"
                    class="rounded-full border border-white/25 bg-white/10 px-6 py-3.5 text-sm font-black text-white transition hover:bg-white hover:text-[#0A2E5D]"
                >
                    Explorer les biens
                </a>
            </div>
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
                    <a href="/" class="block transition hover:text-white">Accueil</a>
                    <a href="{{ route('properties.index') }}" class="block transition hover:text-white">Tous les biens</a>
                    <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block transition hover:text-white">Acheter</a>
                    <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block transition hover:text-white">Louer</a>
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

@endsection
