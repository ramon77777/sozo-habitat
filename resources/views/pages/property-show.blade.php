@extends('layouts.app')

@php
    $photos = collect();

    if ($property->main_image_url) {
        $photos->push($property->main_image_url);
    }

    foreach ($property->images as $image) {
        if ($image->url) {
            $photos->push($image->url);
        }
    }

    $photos = $photos->filter()->unique()->values();

    $seoImage = $photos->first() ?: asset('images/logo.png');

    $phone1Raw = preg_replace('/\D+/', '', $siteSettings->phone_1 ?? '');
    $phone2Raw = preg_replace('/\D+/', '', $siteSettings->phone_2 ?? '');
    $phone1Intl = $phone1Raw ? (str_starts_with($phone1Raw, '225') ? $phone1Raw : '225'.$phone1Raw) : null;
    $phone2Intl = $phone2Raw ? (str_starts_with($phone2Raw, '225') ? $phone2Raw : '225'.$phone2Raw) : null;

    $whatsappRaw = preg_replace('/\D+/', '', $siteSettings->whatsapp ?? '');
    $whatsappIntl = $whatsappRaw ? (str_starts_with($whatsappRaw, '225') ? $whatsappRaw : '225'.$whatsappRaw) : null;
    $whatsappMessage = urlencode(
        'Bonjour, je suis intéressé(e) par le bien « '.$property->title.' » à '.$property->city.'.'
    );

    $propertyTypeLabel = ucfirst(str_replace('_', ' ', $property->type));
    $transactionLabel = $property->transaction === 'vente' ? 'À vendre' : 'À louer';
@endphp

@section('seo')
<x-seo
    :title="$property->title
        . ' - '
        . $propertyTypeLabel
        . ' '
        . ucfirst($property->transaction)
        . ' à '
        . $property->city
        . ' | Sozo Habitat Côte d\'Ivoire'"
    :description="'Découvrez '
        . $property->title
        . ', un(e) '
        . $propertyTypeLabel
        . ' disponible en '
        . $property->transaction
        . ' à '
        . $property->city
        . '. Sozo Habitat vous accompagne dans vos projets immobiliers partout en Côte d\'Ivoire.'"
    :image="$seoImage"
/>

@php
    $propertySchema = [
        '@context' => 'https://schema.org',
        '@type' => 'RealEstateListing',
        'name' => $property->title,
        'description' => $property->description,
        'image' => $photos->all(),
        'offers' => [
            '@type' => 'Offer',
            'price' => $property->price,
            'priceCurrency' => 'XOF',
            'availability' => 'https://schema.org/InStock',
        ],
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $property->city,
            'addressRegion' => $property->district,
            'addressCountry' => 'CI',
        ],
        'url' => url()->current(),
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($propertySchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endsection

@section('content')
<!-- SOZO_PROPERTY_DETAIL_V2 -->

{{-- En-tête du bien --}}
<section class="relative isolate overflow-hidden bg-[#04152C] px-6 pb-24 pt-36 text-white lg:pb-28 lg:pt-40">
    <div class="absolute inset-0 -z-30 bg-[radial-gradient(circle_at_78%_28%,rgba(200,155,60,0.18),transparent_26rem)]"></div>
    <div class="absolute inset-0 -z-30 sozo-grid opacity-[0.06]"></div>
    <div class="absolute -left-24 top-24 -z-20 h-72 w-72 rounded-full border border-white/10"></div>

    <x-navbar />

    <div class="mx-auto max-w-[1400px]">
        <a
            href="{{ route('properties.index') }}"
            class="inline-flex items-center gap-2 text-sm font-bold text-white/65 transition hover:text-[#DDB85F]"
        >
            <span aria-hidden="true">←</span>
            Retour aux biens
        </a>

        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_auto] lg:items-end" data-reveal>
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-[#C89B3C] px-4 py-2 text-[11px] font-black uppercase tracking-[0.16em] text-white">
                        {{ $transactionLabel }}
                    </span>

                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-[11px] font-black uppercase tracking-[0.16em] text-white/80">
                        {{ $propertyTypeLabel }}
                    </span>
                </div>

                <h1 class="mt-5 max-w-4xl text-4xl font-black leading-tight tracking-[-0.035em] sm:text-5xl lg:text-6xl">
                    {{ $property->title }}
                </h1>

                <p class="mt-4 flex items-center gap-2 text-base font-semibold text-slate-300">
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 shrink-0 text-[#DDB85F]" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                        <circle cx="12" cy="10" r="2.2"/>
                    </svg>
                    {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                </p>
            </div>

            <div class="lg:text-right">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-[#DDB85F]">Prix</p>
                <p class="mt-2 text-4xl font-black tracking-tight text-white sm:text-5xl">
                    {{ number_format($property->price, 0, ',', ' ') }}
                    <span class="text-base font-bold text-white/60">FCFA</span>
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Galerie + contact --}}
<section class="relative z-20 -mt-14 bg-[#F7F8FA] px-6 pb-16">
    <div class="mx-auto grid max-w-[1400px] gap-8 lg:grid-cols-[minmax(0,1fr)_380px]">
        <div class="min-w-0">
            <div
                data-reveal
                class="overflow-hidden rounded-[2.3rem] border border-white bg-white p-3 shadow-[0_28px_80px_rgba(4,21,44,0.16)]"
            >
                @if($photos->isNotEmpty())
                    <div class="group relative overflow-hidden rounded-[1.8rem] bg-slate-100">
                        <img
                            id="mainImage"
                            src="{{ $photos->first() }}"
                            alt="{{ $property->title }} - {{ $property->city }} - Sozo Habitat Côte d'Ivoire"
                            class="h-[420px] w-full cursor-zoom-in object-cover transition duration-700 group-hover:scale-[1.015] sm:h-[520px] lg:h-[600px]"
                            loading="eager"
                            onclick="openGallery(currentIndex)"
                        >

                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#04152C]/35 via-transparent to-transparent"></div>

                        @if($photos->count() > 1)
                            <button
                                type="button"
                                onclick="previousImage()"
                                aria-label="Photo précédente"
                                class="absolute left-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/50 bg-[#04152C]/65 text-2xl font-black text-white shadow-lg backdrop-blur transition hover:bg-[#C89B3C]"
                            >
                                ‹
                            </button>

                            <button
                                type="button"
                                onclick="nextImage()"
                                aria-label="Photo suivante"
                                class="absolute right-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/50 bg-[#04152C]/65 text-2xl font-black text-white shadow-lg backdrop-blur transition hover:bg-[#C89B3C]"
                            >
                                ›
                            </button>

                            <div class="absolute bottom-4 right-4 rounded-full border border-white/20 bg-[#04152C]/70 px-4 py-2 text-xs font-black text-white backdrop-blur">
                                <span id="photoCounter">1</span> / {{ $photos->count() }}
                            </div>
                        @endif

                        <button
                            type="button"
                            onclick="openGallery(currentIndex)"
                            class="absolute bottom-4 left-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/95 px-4 py-2 text-xs font-black text-[#0A2E5D] shadow-lg transition hover:bg-[#C89B3C] hover:text-white"
                        >
                            <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4h4M16 4h4v4M20 16v4h-4M8 20H4v-4"/>
                            </svg>
                            Plein écran
                        </button>
                    </div>

                    @if($photos->count() > 1)
                        <div class="mt-3 flex gap-3 overflow-x-auto pb-1">
                            @foreach($photos as $index => $photo)
                                <button
                                    type="button"
                                    onclick="setImage({{ $index }})"
                                    class="shrink-0"
                                    aria-label="Afficher la photo {{ $index + 1 }}"
                                >
                                    <img
                                        src="{{ $photo }}"
                                        data-index="{{ $index }}"
                                        alt="{{ $property->title }} - Photo {{ $index + 1 }}"
                                        loading="lazy"
                                        class="thumbnail h-24 w-32 rounded-2xl border-2 border-transparent object-cover opacity-80 transition duration-300 hover:-translate-y-1 hover:border-[#C89B3C] hover:opacity-100"
                                    >
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex h-[480px] items-center justify-center rounded-[1.8rem] bg-gradient-to-br from-slate-100 to-slate-200 text-center">
                        <div>
                            <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-[#C89B3C] shadow">
                                <svg viewBox="0 0 24 24" fill="none" class="h-8 w-8" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4zM7 15l3-3 3 3 2-2 2 2"/>
                                    <circle cx="9" cy="9" r="1.4"/>
                                </svg>
                            </span>
                            <p class="mt-4 font-black text-[#0A2E5D]">Photos bientôt disponibles</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Caractéristiques --}}
            <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3" data-reveal>
                <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Surface</p>
                    <p class="mt-2 text-2xl font-black text-[#0A2E5D]">
                        {{ $property->surface ?? '—' }} <span class="text-sm text-slate-400">m²</span>
                    </p>
                </div>

                @if($property->type === 'terrain')
                    <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">ACD</p>
                        <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->has_acd ? 'Disponible' : 'Non indiqué' }}</p>
                    </div>

                    <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Lot approuvé</p>
                        <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->is_lot_approved ? 'Oui' : 'Non indiqué' }}</p>
                    </div>

                    @if($property->document_type)
                        <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Document</p>
                            <p class="mt-2 text-xl font-black text-[#0A2E5D]">{{ ucfirst(str_replace('_', ' ', $property->document_type)) }}</p>
                        </div>
                    @endif
                @else
                    <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Chambres</p>
                        <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->bedrooms ?? '—' }}</p>
                    </div>

                    <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Salles d'eau</p>
                        <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->bathrooms ?? '—' }}</p>
                    </div>

                    @if($property->living_rooms)
                        <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Salons</p>
                            <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->living_rooms }}</p>
                        </div>
                    @endif

                    @if($property->kitchens)
                        <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Cuisines</p>
                            <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->kitchens }}</p>
                        </div>
                    @endif

                    @if($property->garages)
                        <div class="sozo-card rounded-[1.7rem] border border-white bg-white p-6 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Garages</p>
                            <p class="mt-2 text-2xl font-black text-[#0A2E5D]">{{ $property->garages }}</p>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Description --}}
            <article class="mt-8 rounded-[2rem] border border-white bg-white p-7 shadow-[0_16px_48px_rgba(15,23,42,0.06)] sm:p-9" data-reveal>
                <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
                    <span class="h-px w-8 bg-[#C89B3C]"></span>
                    À propos du bien
                </div>

                <h2 class="mt-4 text-3xl font-black text-[#0A2E5D]">Description</h2>

                <p class="mt-5 whitespace-pre-line text-base leading-8 text-slate-600">
                    {{ $property->description ?: 'Les informations détaillées de ce bien seront bientôt disponibles.' }}
                </p>
            </article>

            {{-- Vidéos --}}
            @if($property->videos->count())
                <section class="mt-8 rounded-[2rem] border border-white bg-white p-7 shadow-[0_16px_48px_rgba(15,23,42,0.06)] sm:p-9" data-reveal>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-[#C89B3C]">Immersion</p>
                            <h2 class="mt-2 text-3xl font-black text-[#0A2E5D]">Vidéo du bien</h2>
                        </div>

                        <p class="text-sm text-slate-500">Découvrez le bien en mouvement.</p>
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        @foreach($property->videos as $video)
                            <div class="overflow-hidden rounded-[1.6rem] bg-black shadow-lg">
                                <video controls preload="metadata" class="aspect-video h-full w-full object-contain">
                                    <source src="{{ $video->url }}">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Localisation --}}
            @if($property->latitude && $property->longitude)
                <section class="mt-8 overflow-hidden rounded-[2rem] border border-white bg-white shadow-[0_16px_48px_rgba(15,23,42,0.06)]" data-reveal>
                    <div class="flex flex-col gap-5 p-7 sm:flex-row sm:items-center sm:justify-between sm:p-9">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-[#C89B3C]">Localisation</p>
                            <h2 class="mt-2 text-3xl font-black text-[#0A2E5D]">
                                {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                            </h2>
                            @if($property->address)
                                <p class="mt-2 text-slate-500">{{ $property->address }}</p>
                            @endif
                        </div>

                        <a
                            href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-[#0A2E5D] px-6 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#C89B3C]"
                        >
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                <circle cx="12" cy="10" r="2.2"/>
                            </svg>
                            Ouvrir dans Google Maps
                        </a>
                    </div>

                    <iframe
                        src="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}&hl=fr&z=15&output=embed"
                        class="h-[420px] w-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localisation de {{ $property->title }}"
                    ></iframe>
                </section>
            @endif
        </div>

        {{-- Contact sticky --}}
        <aside class="lg:sticky lg:top-28 lg:self-start" data-reveal="right">
            <div class="overflow-hidden rounded-[2rem] bg-[#061A35] p-7 text-white shadow-[0_28px_80px_rgba(4,21,44,0.22)]">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-[#DDB85F]">Ce bien vous intéresse ?</p>

                <p class="mt-3 text-3xl font-black">
                    {{ number_format($property->price, 0, ',', ' ') }}
                    <span class="text-sm font-bold text-white/60">FCFA</span>
                </p>

                <p class="mt-4 text-sm leading-6 text-slate-300">
                    Contactez notre équipe pour obtenir plus d'informations ou organiser une visite.
                </p>

                <div class="mt-6 grid gap-3">
                    <a
                        href="#visite"
                        class="sozo-shine inline-flex items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-5 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
                    >
                        Demander une visite
                    </a>

                    @if($whatsappIntl)
                        <a
                            href="https://wa.me/{{ $whatsappIntl }}?text={{ $whatsappMessage }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-green-500 px-5 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-green-600"
                        >
                            WhatsApp
                        </a>
                    @endif

                    @if($phone1Intl)
                        <a
                            href="tel:+{{ $phone1Intl }}"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/15 bg-white/10 px-5 py-3.5 text-sm font-black text-white transition hover:bg-white hover:text-[#0A2E5D]"
                        >
                            Appeler {{ $siteSettings->phone_1 }}
                        </a>
                    @endif
                </div>

                <div class="mt-7 border-t border-white/10 pt-6">
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#DDB85F]">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="font-black">Type</p>
                                <p class="mt-1 text-slate-300">{{ $propertyTypeLabel }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#DDB85F]">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="font-black">Localisation</p>
                                <p class="mt-1 text-slate-300">{{ $property->city }}@if($property->district), {{ $property->district }}@endif</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#DDB85F]">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14v11H9l-4 3V5Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="font-black">Réponse rapide</p>
                                <p class="mt-1 text-slate-300">Téléphone, WhatsApp ou formulaire de visite.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($phone2Intl)
                <div class="mt-4 rounded-[1.6rem] border border-white bg-white p-5 shadow-[0_14px_40px_rgba(15,23,42,0.06)]">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-[#C89B3C]">Deuxième contact</p>
                    <a href="tel:+{{ $phone2Intl }}" class="mt-2 block text-lg font-black text-[#0A2E5D] transition hover:text-[#C89B3C]">
                        {{ $siteSettings->phone_2 }}
                    </a>
                </div>
            @endif
        </aside>
    </div>
</section>

{{-- Formulaire visite --}}
<section id="visite" class="relative overflow-hidden bg-white px-6 py-20 lg:py-24">
    <div class="absolute inset-0 sozo-grid opacity-30 [mask-image:linear-gradient(to_right,black,transparent_65%)]"></div>

    <div class="relative mx-auto grid max-w-[1400px] gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
        <div data-reveal="left">
            <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
                <span class="h-px w-8 bg-[#C89B3C]"></span>
                Organiser une visite
            </div>

            <h2 class="mt-4 max-w-xl text-4xl font-black tracking-[-0.03em] text-[#0A2E5D] sm:text-5xl">
                Venez découvrir ce bien.
            </h2>

            <p class="mt-5 max-w-xl text-base leading-8 text-slate-500">
                Laissez-nous vos coordonnées. Notre équipe vous recontactera pour convenir d'un créneau et répondre à vos questions.
            </p>

            <div class="mt-8 rounded-[1.8rem] bg-[#061A35] p-6 text-white">
                <p class="text-sm font-black">{{ $property->title }}</p>
                <p class="mt-2 text-sm text-slate-300">
                    {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                </p>
                <p class="mt-4 text-2xl font-black text-[#DDB85F]">
                    {{ number_format($property->price, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>

        <div
            data-reveal="right"
            class="rounded-[2rem] border border-slate-100 bg-white p-7 shadow-[0_24px_70px_rgba(15,23,42,0.10)] sm:p-9"
        >
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 font-semibold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700">
                    <p class="mb-3 font-black">Veuillez corriger les erreurs suivantes :</p>
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('properties.inquiries.store', $property) }}">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Nom complet</span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                            placeholder="Votre nom"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Téléphone</span>
                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            required
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                            placeholder="Votre numéro"
                        >
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-[#0A2E5D]">
                            Email <span class="font-medium text-slate-400">(optionnel)</span>
                        </span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                            placeholder="vous@exemple.com"
                        >
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Message</span>
                        <textarea
                            name="message"
                            rows="5"
                            class="w-full resize-y rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20"
                        >{{ old('message', 'Bonjour, je suis intéressé(e) par ce bien : '.$property->title) }}</textarea>
                    </label>
                </div>

                <button
                    type="submit"
                    class="sozo-shine mt-6 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-8 py-4 text-sm font-black text-white shadow-lg shadow-[#C89B3C]/20 transition hover:-translate-y-0.5 hover:bg-[#B7892E] sm:w-auto"
                >
                    Envoyer ma demande
                    <span aria-hidden="true">→</span>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- CTA + footer --}}
<section class="bg-[#F7F8FA] px-6 py-16">
    <div
        data-reveal
        class="mx-auto grid max-w-[1400px] gap-8 overflow-hidden rounded-[2.4rem] bg-gradient-to-br from-[#0A2E5D] via-[#061A35] to-[#031329] px-7 py-10 text-white shadow-[0_28px_80px_rgba(4,21,44,0.18)] sm:px-10 lg:grid-cols-[1fr_auto] lg:items-center lg:px-14 lg:py-14"
    >
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#DDB85F]">Encore une question ?</p>
            <h2 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">Notre équipe reste disponible.</h2>
            <p class="mt-4 max-w-2xl leading-7 text-slate-300">
                Échangez directement avec Sozo Habitat pour avancer sur votre projet immobilier.
            </p>
        </div>

        <div class="flex flex-wrap gap-3 lg:justify-end">
            @if($whatsappIntl)
                <a
                    href="https://wa.me/{{ $whatsappIntl }}?text={{ $whatsappMessage }}"
                    target="_blank"
                    rel="noopener"
                    class="sozo-shine rounded-full bg-[#C89B3C] px-6 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
                >
                    Écrire sur WhatsApp
                </a>
            @endif

            <a
                href="{{ route('properties.index') }}"
                class="rounded-full border border-white/25 bg-white/10 px-6 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-white hover:text-[#0A2E5D]"
            >
                Voir d'autres biens
            </a>
        </div>
    </div>
</section>

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
                        <a href="tel:+{{ $phone1Intl }}" class="block transition hover:text-white">{{ $siteSettings->phone_1 }}</a>
                    @endif

                    @if($siteSettings->phone_2)
                        <a href="tel:+{{ $phone2Intl }}" class="block transition hover:text-white">{{ $siteSettings->phone_2 }}</a>
                    @endif

                    @if($siteSettings->email)
                        <a href="mailto:{{ $siteSettings->email }}" class="block break-all transition hover:text-white">{{ $siteSettings->email }}</a>
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

@if($whatsappIntl)
    <a
        href="https://wa.me/{{ $whatsappIntl }}?text={{ $whatsappMessage }}"
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

{{-- Galerie plein écran --}}
@if($photos->isNotEmpty())
    <div
        id="galleryModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-[#020914]/95 p-4 backdrop-blur-md"
        onclick="if (event.target === this) closeGallery()"
    >
        <button
            type="button"
            onclick="closeGallery()"
            aria-label="Fermer la galerie"
            class="absolute right-5 top-5 flex h-12 w-12 items-center justify-center rounded-full border border-white/15 bg-white/10 text-3xl text-white transition hover:bg-white hover:text-[#0A2E5D]"
        >
            ×
        </button>

        @if($photos->count() > 1)
            <button
                type="button"
                onclick="previousImage()"
                aria-label="Photo précédente"
                class="absolute left-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-white/10 text-3xl text-white transition hover:bg-white hover:text-[#0A2E5D] sm:left-8"
            >
                ‹
            </button>
        @endif

        <img
            id="modalImage"
            src="{{ $photos->first() }}"
            class="max-h-[86vh] max-w-[88vw] rounded-2xl object-contain shadow-2xl"
            alt="{{ $property->title }} - Galerie Sozo Habitat"
        >

        @if($photos->count() > 1)
            <button
                type="button"
                onclick="nextImage()"
                aria-label="Photo suivante"
                class="absolute right-4 top-1/2 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full border border-white/15 bg-white/10 text-3xl text-white transition hover:bg-white hover:text-[#0A2E5D] sm:right-8"
            >
                ›
            </button>

            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 rounded-full border border-white/15 bg-white/10 px-5 py-2 text-sm font-black text-white backdrop-blur">
                <span id="modalCounter">1</span> / {{ $photos->count() }}
            </div>
        @endif
    </div>
@endif

<script>
const photos = @json($photos->values());
let currentIndex = 0;

function refreshGallery() {
    if (!photos.length) {
        return;
    }

    const mainImage = document.getElementById('mainImage');
    const modalImage = document.getElementById('modalImage');
    const photoCounter = document.getElementById('photoCounter');
    const modalCounter = document.getElementById('modalCounter');

    if (mainImage) {
        mainImage.src = photos[currentIndex];
    }

    if (modalImage) {
        modalImage.src = photos[currentIndex];
    }

    if (photoCounter) {
        photoCounter.textContent = currentIndex + 1;
    }

    if (modalCounter) {
        modalCounter.textContent = currentIndex + 1;
    }

    document.querySelectorAll('.thumbnail').forEach((thumb) => {
        thumb.classList.remove('border-[#C89B3C]', 'opacity-100');
        thumb.classList.add('border-transparent', 'opacity-80');
    });

    const activeThumb = document.querySelector('[data-index="' + currentIndex + '"]');

    if (activeThumb) {
        activeThumb.classList.remove('border-transparent', 'opacity-80');
        activeThumb.classList.add('border-[#C89B3C]', 'opacity-100');
        activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
    }
}

function setImage(index) {
    currentIndex = index;
    refreshGallery();
}

function nextImage() {
    if (!photos.length) {
        return;
    }

    currentIndex = (currentIndex + 1) % photos.length;
    refreshGallery();
}

function previousImage() {
    if (!photos.length) {
        return;
    }

    currentIndex = (currentIndex - 1 + photos.length) % photos.length;
    refreshGallery();
}

function openGallery(index) {
    if (!photos.length) {
        return;
    }

    currentIndex = index;
    refreshGallery();

    const modal = document.getElementById('galleryModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeGallery() {
    const modal = document.getElementById('galleryModal');

    if (!modal) {
        return;
    }

    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('galleryModal');

    if (!modal || modal.classList.contains('hidden')) {
        return;
    }

    if (event.key === 'Escape') {
        closeGallery();
    }

    if (event.key === 'ArrowRight') {
        nextImage();
    }

    if (event.key === 'ArrowLeft') {
        previousImage();
    }
});

refreshGallery();
</script>

@endsection
