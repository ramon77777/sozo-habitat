@extends('layouts.app')

@section('title')
SOZO Habitat | Immobilier en Côte d’Ivoire : Villas, Maisons et Terrains
@endsection

@section('description')
Découvrez des biens immobiliers en Côte d’Ivoire avec SOZO Habitat : villas, maisons, appartements et terrains à vendre ou à louer avec un accompagnement professionnel.
@endsection

@section('content')

@php
    $spotlightProperty = $featuredProperties->first();
@endphp

<x-hero />

{{-- Accès rapides --}}
<section class="relative z-20 -mt-5 px-4 sm:-mt-12 sm:px-6">
    <div class="mx-auto grid max-w-[1260px] gap-4 md:grid-cols-3">
        <a
            href="{{ route('properties.index', ['transaction' => 'vente']) }}"
            data-reveal
            data-reveal-delay="0"
            class="sozo-card group rounded-[1.5rem] border border-white/70 bg-white p-5 shadow-[0_18px_55px_rgba(4,21,44,0.12)] sm:rounded-[1.7rem] sm:p-6"
        >
            <div class="flex items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E1B44B] transition duration-300 group-hover:rotate-3 group-hover:scale-105">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                            <path stroke-linecap="round" d="M9 20v-5h6v5"/>
                        </svg>
                    </span>

                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-[#C89B3C]">Acheter</p>
                        <h2 class="mt-1 text-lg font-black text-[#0A2E5D]">Trouvez votre futur bien</h2>
                    </div>
                </div>

                <span class="text-xl text-[#0A2E5D] transition group-hover:translate-x-1">→</span>
            </div>
        </a>

        <a
            href="{{ route('properties.index', ['transaction' => 'location']) }}"
            data-reveal
            data-reveal-delay="90"
            class="sozo-card group rounded-[1.5rem] border border-white/70 bg-white p-5 shadow-[0_18px_55px_rgba(4,21,44,0.12)] sm:rounded-[1.7rem] sm:p-6"
        >
            <div class="flex items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E1B44B] transition duration-300 group-hover:rotate-3 group-hover:scale-105">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5 12 7l5 4.5M8.5 10.5V18h7v-7.5"/>
                            <path stroke-linecap="round" d="M4 20h16"/>
                        </svg>
                    </span>

                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-[#C89B3C]">Louer</p>
                        <h2 class="mt-1 text-lg font-black text-[#0A2E5D]">Installez-vous sereinement</h2>
                    </div>
                </div>

                <span class="text-xl text-[#0A2E5D] transition group-hover:translate-x-1">→</span>
            </div>
        </a>

        <a
            href="{{ route('properties.index', ['type' => 'terrain']) }}"
            data-reveal
            data-reveal-delay="180"
            class="sozo-card group rounded-[1.5rem] border border-white/70 bg-white p-5 shadow-[0_18px_55px_rgba(4,21,44,0.12)] sm:rounded-[1.7rem] sm:p-6"
        >
            <div class="flex items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E1B44B] transition duration-300 group-hover:rotate-3 group-hover:scale-105">
                        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 18 5-12 4 7 3-5 4 10H4Z"/>
                        </svg>
                    </span>

                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.18em] text-[#C89B3C]">Investir</p>
                        <h2 class="mt-1 text-lg font-black text-[#0A2E5D]">Découvrez nos terrains</h2>
                    </div>
                </div>

                <span class="text-xl text-[#0A2E5D] transition group-hover:translate-x-1">→</span>
            </div>
        </a>
    </div>
</section>

{{-- Biens en vedette --}}
<section id="biens" class="relative mt-6 overflow-hidden bg-[#061A35] px-4 py-14 text-white sm:mt-8 sm:px-6 sm:py-20 lg:mt-12 lg:py-28">
    <div class="pointer-events-none absolute -left-24 top-20 h-72 w-72 rounded-full bg-[#C89B3C]/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-20 bottom-0 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>

    <div class="relative mx-auto max-w-[1450px]">
        <div class="mb-8 flex flex-col gap-6 sm:mb-12 sm:gap-7 md:flex-row md:items-end md:justify-between" data-reveal>
            <div>
                <div class="inline-flex items-center gap-2.5 text-[10px] font-black uppercase tracking-[0.22em] text-[#DDB85F] sm:gap-3 sm:text-xs sm:tracking-[0.28em]">
                    <span class="h-px w-8 bg-[#DDB85F]"></span>
                    Sélection premium
                </div>

                <h2 class="mt-3 max-w-3xl text-3xl font-black leading-[1.03] tracking-[-0.03em] text-white sm:mt-4 sm:text-4xl md:text-5xl lg:text-6xl">
                    Les opportunités qui méritent votre attention.
                </h2>

                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300 sm:mt-5 sm:text-base sm:leading-8">
                    Une sélection de biens à vendre ou à louer, présentés avec leurs informations essentielles pour vous aider à décider plus vite.
                </p>
            </div>

            <a
                href="{{ route('properties.index') }}"
                class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-3.5 text-sm font-black text-white backdrop-blur transition hover:-translate-y-0.5 hover:bg-white hover:text-[#0A2E5D] sm:w-auto sm:px-6"
            >
                Voir tout le catalogue
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 justify-items-center gap-5 sm:gap-7">
            @forelse($featuredProperties as $property)
                <article
                    data-reveal
                    data-reveal-delay="{{ ($loop->index % 4) * 90 }}"
                    class="sozo-card group w-full max-w-[430px] overflow-hidden rounded-[1.7rem] border border-white/10 bg-white text-slate-900 shadow-[0_24px_70px_rgba(0,0,0,0.22)] sm:rounded-[2rem]"
                >
                    <a href="{{ route('properties.show', $property) }}" class="block">
                        <div class="sozo-media relative h-[240px] bg-slate-100 sm:h-[300px] lg:h-[330px]">
                            @if($property->main_image_url)
                                <img
                                    src="{{ $property->main_image_url }}"
                                    alt="{{ $property->title }}"
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

                            <div class="mt-6 grid grid-cols-3 divide-x divide-slate-100 rounded-2xl bg-[#F7F8FA] px-2 py-4 text-center">
                                <div class="px-2">
                                    <p class="text-base font-black text-[#0A2E5D]">{{ $property->surface ?? '-' }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">m²</p>
                                </div>
                                <div class="px-2">
                                    <p class="text-base font-black text-[#0A2E5D]">{{ $property->type === 'terrain' ? '-' : ($property->bedrooms ?? '-') }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Chambres</p>
                                </div>
                                <div class="px-2">
                                    <p class="text-base font-black text-[#0A2E5D]">{{ $property->type === 'terrain' ? '-' : ($property->bathrooms ?? '-') }}</p>
                                    <p class="mt-1 text-[11px] font-semibold text-slate-400">Bains</p>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-between">
                                <span class="text-sm font-black text-[#0A2E5D] transition group-hover:text-[#C89B3C]">
                                    Découvrir ce bien
                                </span>

                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-[#0A2E5D] text-white transition duration-300 group-hover:rotate-[-8deg] group-hover:bg-[#C89B3C]">
                                    →
                                </span>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full rounded-[2rem] border border-dashed border-white/20 bg-white/5 p-12 text-center">
                    <h3 class="text-xl font-black text-white">Nos prochaines opportunités arrivent bientôt.</h3>
                    <p class="mt-2 text-slate-300">Consultez l'ensemble de nos biens disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Expertise --}}
<section id="services" class="relative overflow-hidden bg-[#F6F7F9] px-4 py-14 sm:px-6 sm:py-20 lg:py-28">
    <div class="pointer-events-none absolute left-0 top-0 h-full w-full sozo-grid opacity-40 [mask-image:linear-gradient(to_right,black,transparent_55%)]"></div>

    <div class="relative mx-auto max-w-[1400px]">
        <div class="grid gap-9 sm:gap-14 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">
            <div data-reveal="left">
                <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.28em] text-[#C89B3C]">
                    <span class="h-px w-8 bg-[#C89B3C]"></span>
                    Pourquoi Sozo Habitat
                </div>

                <h2 class="mt-3 max-w-xl text-3xl font-black leading-[1.04] tracking-[-0.03em] text-[#0A2E5D] sm:mt-4 sm:text-4xl md:text-5xl lg:text-6xl">
                    Une expérience immobilière plus humaine.
                </h2>

                <p class="mt-4 max-w-xl text-sm leading-6 text-slate-500 sm:mt-6 sm:text-base sm:leading-8">
                    Nous mettons l'accent sur la qualité de présentation, la simplicité de la recherche et la disponibilité de notre équipe pour rendre chaque étape plus fluide.
                </p>

                <a
                    href="/#contact"
                    class="mt-7 inline-flex items-center gap-2 text-sm font-black text-[#0A2E5D] transition hover:text-[#C89B3C]"
                >
                    Échanger avec notre équipe
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                @foreach([
                    ['home', 'Biens bien présentés', 'Photos, informations essentielles et caractéristiques réunies dans une lecture claire.'],
                    ['shield', 'Accompagnement dédié', 'Une équipe disponible pour vous guider de la recherche jusqu’à la visite.'],
                    ['pin', 'Connaissance locale', 'Des biens et terrains proposés dans plusieurs villes et communes de Côte d’Ivoire.'],
                    ['chat', 'Contact simplifié', 'Téléphone, WhatsApp ou formulaire : contactez-nous par le canal qui vous convient.'],
                ] as [$icon, $title, $text])
                    <article
                        data-reveal
                        data-reveal-delay="{{ ($loop->index % 2) * 100 }}"
                        class="sozo-card rounded-[1.6rem] border border-white bg-white p-5 shadow-[0_18px_55px_rgba(15,23,42,0.07)] sm:rounded-[2rem] sm:p-7"
                    >
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#E2B64F] shadow-lg shadow-[#0A2E5D]/10">
                            @if($icon === 'home')
                                <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                                    <path stroke-linecap="round" d="M9 20v-5h6v5"/>
                                </svg>
                            @elseif($icon === 'shield')
                                <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12.5 11 15l4.8-5.2M12 3 5 6v5c0 4.5 2.8 8.2 7 10 4.2-1.8 7-5.5 7-10V6l-7-3Z"/>
                                </svg>
                            @elseif($icon === 'pin')
                                <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                    <circle cx="12" cy="10" r="2.2"/>
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14v11H9l-4 3V5Z"/>
                                    <path stroke-linecap="round" d="M8 9h8M8 12h5"/>
                                </svg>
                            @endif
                        </div>

                        <h3 class="mt-5 text-xl font-black text-[#0A2E5D]">{{ $title }}</h3>
                        <p class="mt-3 leading-7 text-slate-500">{{ $text }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Parcours immobilier --}}
<section class="relative overflow-hidden bg-white px-4 py-14 sm:px-6 sm:py-20 lg:py-28">
    <div class="mx-auto max-w-[1400px]">
        <div class="grid gap-6 sm:gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-stretch">
            <div
                data-reveal="left"
                class="relative min-h-[390px] overflow-hidden rounded-[1.8rem] bg-[#061A35] shadow-[0_30px_80px_rgba(4,21,44,0.18)] sm:min-h-[480px] sm:rounded-[2.4rem]"
            >
                @if($spotlightProperty && $spotlightProperty->main_image_url)
                    <img
                        src="{{ $spotlightProperty->main_image_url }}"
                        alt="{{ $spotlightProperty->title }}"
                        loading="lazy"
                        class="absolute inset-0 h-full w-full object-cover"
                    >
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-[#04152C]/95 via-[#04152C]/35 to-[#04152C]/15"></div>

                <div class="absolute inset-x-0 bottom-0 p-6 text-white sm:p-10">
                    <p class="text-xs font-black uppercase tracking-[0.25em] text-[#DDB85F]">
                        Une recherche qui avance
                    </p>
                    <h2 class="mt-3 max-w-lg text-3xl font-black leading-[1.04] tracking-tight sm:mt-4 sm:text-5xl">
                        Votre projet mérite plus qu’une simple annonce.
                    </h2>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-200 sm:mt-4 sm:text-base sm:leading-7">
                        Comparez, posez vos questions et planifiez une visite depuis une expérience simple et lisible.
                    </p>
                </div>
            </div>

            <div data-reveal="right" class="rounded-[1.8rem] border border-slate-100 bg-[#F7F8FA] p-5 sm:rounded-[2.4rem] sm:p-10">
                <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.28em] text-[#C89B3C]">
                    <span class="h-px w-8 bg-[#C89B3C]"></span>
                    Comment ça fonctionne
                </div>

                <h2 class="mt-3 text-3xl font-black leading-[1.04] tracking-tight text-[#0A2E5D] sm:mt-4 sm:text-5xl">
                    De la recherche à la visite.
                </h2>

                <div class="mt-6 space-y-3 sm:mt-8 sm:space-y-4">
                    @foreach([
                        ['01', 'Affinez votre recherche', 'Choisissez la ville, le type de bien et votre projet : achat ou location.'],
                        ['02', 'Explorez les détails', 'Consultez les photos, le prix, la surface et les caractéristiques du bien.'],
                        ['03', 'Envoyez votre demande', 'Demandez une visite ou contactez directement notre équipe.'],
                        ['04', 'Avancez accompagné', 'Échangez avec nous pour poursuivre votre projet immobilier.'],
                    ] as [$number, $title, $text])
                        <div class="group flex gap-3 rounded-2xl border border-transparent bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#C89B3C]/20 hover:shadow-lg sm:gap-4 sm:p-5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#0A2E5D] text-xs font-black text-[#E2B64F] transition group-hover:bg-[#C89B3C] group-hover:text-white">
                                {{ $number }}
                            </span>

                            <div>
                                <h3 class="font-black text-[#0A2E5D]">{{ $title }}</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-500">{{ $text }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="relative overflow-hidden bg-[#F6F7F9] px-4 py-14 sm:px-6 sm:py-20">
    <div class="pointer-events-none absolute left-1/2 top-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#C89B3C]/10 blur-3xl"></div>

    <div
        data-reveal
        class="relative mx-auto max-w-[1400px] overflow-hidden rounded-[1.8rem] bg-gradient-to-br from-[#0A2E5D] via-[#061A35] to-[#031329] px-5 py-9 text-white shadow-[0_30px_90px_rgba(4,21,44,0.24)] sm:rounded-[2.5rem] sm:px-10 sm:py-12 lg:px-14 lg:py-16"
    >
        <div class="absolute -right-16 -top-16 h-52 w-52 rounded-full border border-white/10"></div>
        <div class="absolute -right-3 -top-3 h-28 w-28 rounded-full border border-[#C89B3C]/20"></div>

        <div class="relative grid gap-10 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.28em] text-[#DDB85F]">Un projet immobilier ?</p>
                <h2 class="mt-3 max-w-3xl text-3xl font-black leading-[1.04] tracking-[-0.03em] sm:text-5xl">
                    Faisons avancer votre recherche.
                </h2>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base sm:leading-8">
                    Achat, location ou terrain : dites-nous ce que vous recherchez et notre équipe vous aidera à identifier les opportunités adaptées.
                </p>
            </div>

            <div class="grid gap-3 sm:flex sm:flex-wrap lg:justify-end">
                @if($siteSettings->whatsapp)
                    <a
                        href="https://wa.me/{{ $siteSettings->whatsapp }}"
                        target="_blank"
                        rel="noopener"
                        class="sozo-shine w-full rounded-full bg-[#C89B3C] px-5 py-3.5 text-center text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#B7892E] sm:w-auto sm:px-6"
                    >
                        Écrire sur WhatsApp
                    </a>
                @endif

                <a
                    href="{{ route('properties.index') }}"
                    class="w-full rounded-full border border-white/25 bg-white/10 px-5 py-3.5 text-center text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-white hover:text-[#0A2E5D] sm:w-auto sm:px-6"
                >
                    Explorer les biens
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer id="contact" class="bg-[#04152C] px-4 pb-6 pt-10 text-white sm:px-6 sm:pb-8 sm:pt-16">
    <div class="mx-auto max-w-[1400px]">
        <div class="grid grid-cols-2 gap-x-6 gap-y-8 border-b border-white/10 pb-8 sm:gap-10 sm:pb-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="col-span-2 lg:col-span-2">
                <a
                    href="/"
                    class="group inline-flex transition duration-300 hover:-translate-y-0.5"
                    aria-label="Sozo Habitat - Accueil"
                >
                    <img
                        src="{{ asset('images/branding/sozo-habitat-logo-dark.svg') }}"
                        alt="Sozo Habitat - La référence en immobilier"
                        class="h-24 w-auto object-contain sm:h-36 lg:h-40"
                    >
                </a>

                <p class="mt-4 max-w-lg text-sm leading-6 text-slate-300 sm:mt-6 sm:text-base sm:leading-7">
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
                <div class="mt-4 space-y-2.5 text-sm font-semibold text-slate-300 sm:mt-5 sm:space-y-3">
                    <a href="/" class="block transition hover:translate-x-1 hover:text-white">Accueil</a>
                    <a href="{{ route('properties.index') }}" class="block transition hover:translate-x-1 hover:text-white">Tous les biens</a>
                    <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block transition hover:translate-x-1 hover:text-white">Acheter</a>
                    <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block transition hover:translate-x-1 hover:text-white">Louer</a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-black uppercase tracking-[0.18em] text-[#DDB85F]">Nous contacter</h3>

                <div class="mt-4 space-y-2.5 text-sm text-slate-300 sm:mt-5 sm:space-y-3">
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

        <div class="flex flex-col gap-3 pt-5 text-[11px] text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:pt-7 sm:text-xs">
            <p>© {{ date('Y') }} {{ $siteSettings->site_name ?? 'Sozo Habitat' }}. Tous droits réservés.</p>

            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 sm:gap-x-5">
                <p>Immobilier en Côte d'Ivoire.</p>

                <a
                    href="{{ route('workspace') }}"
                    class="inline-flex items-center gap-1.5 text-slate-500 transition hover:text-[#DDB85F]"
                    aria-label="Accéder à l'espace professionnel Sozo Habitat"
                >
                    <svg viewBox="0 0 24 24" fill="none" class="h-3.5 w-3.5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3M6 10h12v10H6V10Z"/>
                    </svg>
                    Espace professionnel
                </a>
            </div>
        </div>
    </div>
</footer>

@if($siteSettings->whatsapp)
    <a
        href="https://wa.me/{{ $siteSettings->whatsapp }}"
        target="_blank"
        rel="noopener"
        class="sozo-whatsapp flex h-12 w-12 items-center justify-center rounded-full bg-green-500 text-white transition hover:-translate-y-1 hover:bg-green-600 sm:h-14 sm:w-14"
        aria-label="Contacter Sozo Habitat sur WhatsApp"
    >
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
            <path d="M12.05 2a9.88 9.88 0 0 0-8.46 15.02L2.2 22l5.1-1.34A9.98 9.98 0 1 0 12.05 2Zm0 17.98a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.02.8.81-2.95-.2-.3A8.05 8.05 0 1 1 12.05 20Zm4.42-6.04c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.19-.71-.63-1.19-1.42-1.33-1.66-.14-.24-.02-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.19-.47-.39-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.1.16 1.51.1.46-.07 1.43-.58 1.63-1.15.2-.56.2-1.05.14-1.15-.06-.1-.22-.16-.46-.28Z"/>
        </svg>
    </a>
@endif

@endsection
