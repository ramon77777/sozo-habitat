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
<section class="sozo-property-body relative z-20 -mt-14 bg-[#F7F8FA] px-4 pb-10 sm:px-6 sm:pb-12 lg:pb-14">
    <div class="mx-auto grid max-w-[1400px] gap-8 lg:grid-cols-[minmax(0,1fr)_380px]">
        <div class="min-w-0">
            <div
                data-reveal
                class="sozo-property-gallery-card overflow-hidden rounded-[2rem] border border-white bg-white p-2.5 shadow-[0_28px_80px_rgba(4,21,44,0.16)] sm:rounded-[2.3rem] sm:p-3"
            >
                @if($photos->isNotEmpty())
                    <div class="group relative overflow-hidden rounded-[1.8rem] bg-slate-100">
                        <img
                            id="mainImage"
                            src="{{ $photos->first() }}"
                            alt="{{ $property->title }} - {{ $property->city }} - Sozo Habitat Côte d'Ivoire"
                            class="sozo-property-main-image h-[310px] w-full cursor-zoom-in object-cover transition duration-700 group-hover:scale-[1.015] sm:h-[500px] lg:h-[560px]"
                            loading="eager"
                            onclick="openGallery(currentIndex)"
                        >

                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#04152C]/35 via-transparent to-transparent"></div>

                        @if($photos->count() > 1)
                            <button
                                type="button"
                                onclick="previousImage()"
                                aria-label="Photo précédente"
                                class="sozo-property-gallery-arrow absolute left-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/50 bg-[#04152C]/65 text-2xl font-black text-white shadow-lg backdrop-blur transition hover:bg-[#C89B3C] sm:left-4 sm:h-12 sm:w-12"
                            >
                                ‹
                            </button>

                            <button
                                type="button"
                                onclick="nextImage()"
                                aria-label="Photo suivante"
                                class="sozo-property-gallery-arrow absolute right-3 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/50 bg-[#04152C]/65 text-2xl font-black text-white shadow-lg backdrop-blur transition hover:bg-[#C89B3C] sm:right-4 sm:h-12 sm:w-12"
                            >
                                ›
                            </button>

                            <div class="absolute bottom-3 right-3 rounded-full border border-white/20 bg-[#04152C]/70 px-3 py-2 text-[11px] font-black text-white backdrop-blur sm:bottom-4 sm:right-4 sm:px-4 sm:text-xs">
                                <span id="photoCounter">1</span> / {{ $photos->count() }}
                            </div>
                        @endif

                        <button
                            type="button"
                            onclick="openGallery(currentIndex)"
                            class="absolute bottom-3 left-3 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/95 px-3 py-2 text-[11px] font-black text-[#0A2E5D] shadow-lg transition hover:bg-[#C89B3C] hover:text-white sm:bottom-4 sm:left-4 sm:px-4 sm:text-xs"
                        >
                            <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4h4M16 4h4v4M20 16v4h-4M8 20H4v-4"/>
                            </svg>
                            Plein écran
                        </button>
                    </div>

                    @if($photos->count() > 1)
                        <div class="sozo-property-thumbnails mt-2.5 flex gap-2.5 overflow-x-auto pb-1 sm:mt-3 sm:gap-3">
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
                                        class="thumbnail h-20 w-28 rounded-xl border-2 border-transparent object-cover opacity-80 transition duration-300 hover:-translate-y-1 hover:border-[#C89B3C] hover:opacity-100 sm:h-24 sm:w-32 sm:rounded-2xl"
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
            <section class="sozo-property-features mt-6" data-reveal>
                <div class="mb-4 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-[#C89B3C]">Le bien en un coup d'œil</p>
                        <h2 class="mt-2 text-2xl font-black text-[#0A2E5D]">Caractéristiques</h2>
                    </div>
                </div>

                <div class="sozo-property-features-grid grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-3">
                    <div class="sozo-card sozo-property-feature-card flex min-w-0 items-center gap-3 rounded-[1.35rem] border border-white bg-white p-4 shadow-[0_12px_34px_rgba(15,23,42,0.06)] sm:gap-4 sm:rounded-[1.5rem] sm:p-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#DDB85F]">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19V5h14v14H5Z M8 16l8-8"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">Surface</p>
                            <p class="mt-1 text-xl font-black text-[#0A2E5D]">{{ $property->surface ?? '—' }} <span class="text-sm text-slate-400">m²</span></p>
                        </div>
                    </div>

                    @if($property->type === 'terrain')
                        <div class="sozo-card sozo-property-feature-card flex min-w-0 items-center gap-3 rounded-[1.35rem] border border-white bg-white p-4 shadow-[0_12px_34px_rgba(15,23,42,0.06)] sm:gap-4 sm:rounded-[1.5rem] sm:p-5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#DDB85F]">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 9 16l10-10"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">ACD</p>
                                <p class="mt-1 text-xl font-black text-[#0A2E5D]">{{ $property->has_acd ? 'Disponible' : 'Non indiqué' }}</p>
                            </div>
                        </div>

                        <div class="sozo-card sozo-property-feature-card flex min-w-0 items-center gap-3 rounded-[1.35rem] border border-white bg-white p-4 shadow-[0_12px_34px_rgba(15,23,42,0.06)] sm:gap-4 sm:rounded-[1.5rem] sm:p-5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#DDB85F]">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h12v16H6z M9 8h6M9 12h6"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">Lot approuvé</p>
                                <p class="mt-1 text-xl font-black text-[#0A2E5D]">{{ $property->is_lot_approved ? 'Oui' : 'Non indiqué' }}</p>
                            </div>
                        </div>

                        @if($property->document_type)
                            <div class="sozo-card sozo-property-feature-card flex min-w-0 items-center gap-3 rounded-[1.35rem] border border-white bg-white p-4 shadow-[0_12px_34px_rgba(15,23,42,0.06)] sm:gap-4 sm:rounded-[1.5rem] sm:p-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#DDB85F]">
                                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l3 3v15H7V3Z M14 3v4h4"/>
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">Document</p>
                                    <p class="mt-1 text-lg font-black text-[#0A2E5D]">{{ ucfirst(str_replace('_', ' ', $property->document_type)) }}</p>
                                </div>
                            </div>
                        @endif
                    @else
                        @foreach([
                            ['Chambres', $property->bedrooms, 'bed'],
                            ["Salles d'eau", $property->bathrooms, 'bath'],
                            ['Salons', $property->living_rooms, 'sofa'],
                            ['Cuisines', $property->kitchens, 'kitchen'],
                            ['Garages', $property->garages, 'garage'],
                        ] as [$label, $value, $icon])
                            @if($value)
                                <div class="sozo-card sozo-property-feature-card flex min-w-0 items-center gap-3 rounded-[1.35rem] border border-white bg-white p-4 shadow-[0_12px_34px_rgba(15,23,42,0.06)] sm:gap-4 sm:rounded-[1.5rem] sm:p-5">
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#0A2E5D] text-[#DDB85F]">
                                        @if($icon === 'bed')
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 18v-7h16v7M4 14h16M7 11V7h5a3 3 0 0 1 3 3v1"/>
                                            </svg>
                                        @elseif($icon === 'bath')
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16v3a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-3ZM7 12V7a3 3 0 0 1 6 0"/>
                                            </svg>
                                        @elseif($icon === 'sofa')
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12V9a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v3M4 12h16v6H4v-6ZM7 18v2M17 18v2"/>
                                            </svg>
                                        @elseif($icon === 'kitchen')
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 3v7M10 3v7M6 7h4M8 10v11M17 3v18M14 7h6"/>
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 10 6 5h12l2 5v9H4v-9ZM7 15h.01M17 15h.01"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="text-[11px] font-black uppercase tracking-[0.16em] text-slate-400">{{ $label }}</p>
                                        <p class="mt-1 text-xl font-black text-[#0A2E5D]">{{ $value }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>

            {{-- Description --}}
            <article class="sozo-property-description mt-6 rounded-[1.75rem] border border-white bg-white p-5 shadow-[0_14px_42px_rgba(15,23,42,0.06)] sm:rounded-[2rem] sm:p-8" data-reveal>
                <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
                    <span class="h-px w-8 bg-[#C89B3C]"></span>
                    À propos du bien
                </div>

                <h2 class="mt-3 text-2xl font-black text-[#0A2E5D]">Description</h2>

                @if($property->description)
                    <p class="mt-4 whitespace-pre-line text-base leading-8 text-slate-600">{{ $property->description }}</p>
                @else
                    <div class="mt-4 flex items-start gap-4 rounded-2xl bg-[#F7F8FA] p-5">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#C89B3C] shadow-sm">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5M12 17h.01"/>
                                <circle cx="12" cy="12" r="9"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-black text-[#0A2E5D]">Informations complémentaires sur demande</p>
                            <p class="mt-1 text-sm leading-6 text-slate-500">Notre équipe peut vous transmettre les détails supplémentaires de ce bien et répondre à vos questions.</p>
                        </div>
                    </div>
                @endif
            </article>

            {{-- Vidéos --}}
            @if($property->videos->count())
                <section class="sozo-property-video mt-6 overflow-hidden rounded-[1.75rem] border border-white bg-white shadow-[0_14px_42px_rgba(15,23,42,0.06)] sm:rounded-[2rem]" data-reveal>
                    <div class="sozo-property-video-head flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-end sm:justify-between sm:p-8">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-[#C89B3C]">Immersion</p>
                            <h2 class="mt-2 text-2xl font-black text-[#0A2E5D]">Visitez le bien en vidéo</h2>
                        </div>
                        <p class="max-w-md text-sm leading-6 text-slate-500">Un aperçu complémentaire pour mieux vous projeter avant votre visite.</p>
                    </div>

                    <div class="sozo-property-video-body {{ $property->videos->count() > 1 ? 'grid gap-3 p-3 sm:grid-cols-2 sm:gap-4 sm:p-4' : 'p-3 sm:p-4' }}">
                        @foreach($property->videos as $video)
                            <div class="overflow-hidden rounded-[1.5rem] bg-black shadow-lg">
                                <video
                                    controls
                                    preload="metadata"
                                    playsinline
                                    class="aspect-video w-full object-contain {{ $property->videos->count() === 1 ? 'max-h-[560px]' : '' }}"
                                >
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
                <section class="sozo-property-location mt-6 overflow-hidden rounded-[1.75rem] border border-white bg-white shadow-[0_14px_42px_rgba(15,23,42,0.06)] sm:rounded-[2rem]" data-reveal>
                    <div class="sozo-property-location-head flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-9">
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
                        class="sozo-property-map h-[285px] w-full border-0 sm:h-[400px]"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Localisation de {{ $property->title }}"
                    ></iframe>
                </section>
            @endif
        </div>

        {{-- Contact sticky --}}
        <aside class="sozo-property-contact lg:sticky lg:top-24 lg:self-start" data-reveal="right">
            <div class="sozo-property-contact-card overflow-hidden rounded-[1.75rem] bg-[#061A35] p-5 text-white shadow-[0_24px_70px_rgba(4,21,44,0.20)] sm:rounded-[2rem] sm:p-7">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-[0.22em] text-[#DDB85F]">Ce bien vous intéresse ?</p>
                        <p class="mt-2 text-2xl font-black sm:text-3xl">
                            {{ number_format($property->price, 0, ',', ' ') }}
                            <span class="text-xs font-bold text-white/60">FCFA</span>
                        </p>
                    </div>

                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-[#DDB85F]">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14v11H9l-4 3V5Z"/>
                        </svg>
                    </span>
                </div>

                <p class="mt-3 text-sm leading-6 text-slate-300">
                    Contactez notre équipe ou planifiez directement une visite.
                </p>

                <div class="sozo-property-contact-actions mt-4 grid gap-2.5">
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
                </div>

                @if($phone1Intl || $phone2Intl)
                    <div class="sozo-property-contact-phones mt-4 grid gap-2 border-t border-white/10 pt-4 {{ $phone1Intl && $phone2Intl ? 'sm:grid-cols-2 lg:grid-cols-1' : '' }}">
                        @if($phone1Intl)
                            <a
                                href="tel:+{{ $phone1Intl }}"
                                class="flex items-center justify-between gap-3 rounded-2xl border border-white/10 bg-white/[0.07] px-4 py-3 text-sm font-bold text-white transition hover:bg-white hover:text-[#0A2E5D]"
                            >
                                <span>
                                    <span class="block text-[10px] font-black uppercase tracking-[0.14em] text-[#DDB85F]">Téléphone</span>
                                    <span class="mt-1 block">{{ $siteSettings->phone_1 }}</span>
                                </span>
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16 16 8M10 8h6v6"/>
                                </svg>
                            </a>
                        @endif

                        @if($phone2Intl)
                            <a
                                href="tel:+{{ $phone2Intl }}"
                                class="flex items-center justify-between gap-3 rounded-2xl border border-white/10 bg-white/[0.07] px-4 py-3 text-sm font-bold text-white transition hover:bg-white hover:text-[#0A2E5D]"
                            >
                                <span>
                                    <span class="block text-[10px] font-black uppercase tracking-[0.14em] text-[#DDB85F]">Deuxième contact</span>
                                    <span class="mt-1 block">{{ $siteSettings->phone_2 }}</span>
                                </span>
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16 16 8M10 8h6v6"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif

                <div class="sozo-property-contact-meta mt-4 grid gap-3 border-t border-white/10 pt-4 text-sm">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#DDB85F]">
                            <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 11.5 12 5l8 6.5V20H4v-8.5Z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-black">Type</p>
                            <p class="text-slate-300">{{ $propertyTypeLabel }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#DDB85F]">
                            <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s6-5.1 6-11a6 6 0 1 0-12 0c0 5.9 6 11 6 11Z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-black">Localisation</p>
                            <p class="text-slate-300">{{ $property->city }}@if($property->district), {{ $property->district }}@endif</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>

{{-- Formulaire visite --}}
<section id="visite" class="sozo-property-visit relative overflow-hidden bg-white px-4 py-12 sm:px-6 sm:py-16 lg:py-20">
    <div class="absolute inset-0 sozo-grid opacity-30 [mask-image:linear-gradient(to_right,black,transparent_65%)]"></div>

    <div class="sozo-property-visit-grid relative mx-auto grid max-w-[1400px] gap-7 sm:gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
        <div data-reveal="left">
            <div class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
                <span class="h-px w-8 bg-[#C89B3C]"></span>
                Organiser une visite
            </div>

            <h2 class="mt-3 max-w-xl text-3xl font-black tracking-[-0.03em] text-[#0A2E5D] sm:mt-4 sm:text-5xl">
                Venez découvrir ce bien.
            </h2>

            <p class="mt-4 max-w-xl text-sm leading-7 text-slate-500 sm:mt-5 sm:text-base sm:leading-8">
                Laissez-nous vos coordonnées. Notre équipe vous recontactera pour convenir d'un créneau et répondre à vos questions.
            </p>

            <div class="mt-6 rounded-[1.5rem] bg-[#061A35] p-5 text-white sm:mt-8 sm:rounded-[1.8rem] sm:p-6">
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
            class="sozo-property-visit-form rounded-[1.75rem] border border-slate-100 bg-white p-5 shadow-[0_24px_70px_rgba(15,23,42,0.10)] sm:rounded-[2rem] sm:p-9"
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

                <div class="grid gap-4 md:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Nom complet</span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3.5 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20 sm:px-5 sm:py-4"
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
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3.5 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20 sm:px-5 sm:py-4"
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
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3.5 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20 sm:px-5 sm:py-4"
                            placeholder="vous@exemple.com"
                        >
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Message</span>
                        <textarea
                            name="message"
                            rows="4"
                            class="w-full resize-y rounded-2xl border border-slate-200 px-4 py-3.5 outline-none transition focus:border-[#C89B3C] focus:ring-2 focus:ring-[#C89B3C]/20 sm:px-5 sm:py-4"
                        >{{ old('message', 'Bonjour, je suis intéressé(e) par ce bien : '.$property->title) }}</textarea>
                    </label>
                </div>

                <button
                    type="submit"
                    class="sozo-shine mt-5 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-8 py-3.5 text-sm font-black text-white shadow-lg shadow-[#C89B3C]/20 transition hover:-translate-y-0.5 hover:bg-[#B7892E] sm:mt-6 sm:w-auto sm:py-4"
                >
                    Envoyer ma demande
                    <span aria-hidden="true">→</span>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- CTA + footer --}}
<section class="sozo-property-final-cta bg-[#F7F8FA] px-4 py-10 sm:px-6 sm:py-12 lg:py-14">
    <div
        data-reveal
        class="mx-auto grid max-w-[1400px] gap-6 overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0A2E5D] via-[#061A35] to-[#031329] px-5 py-8 text-white shadow-[0_28px_80px_rgba(4,21,44,0.18)] sm:gap-8 sm:rounded-[2.4rem] sm:px-10 sm:py-10 lg:grid-cols-[1fr_auto] lg:items-center lg:px-14 lg:py-14"
    >
        <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-[#DDB85F]">Encore une question ?</p>
            <h2 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">Notre équipe reste disponible.</h2>
            <p class="mt-4 max-w-2xl leading-7 text-slate-300">
                Échangez directement avec Sozo Habitat pour avancer sur votre projet immobilier.
            </p>
        </div>

        <div class="sozo-property-final-actions flex flex-wrap gap-3 lg:justify-end">
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

<x-public-footer
    :site-settings="$siteSettings"
    :phone1-intl="$phone1Intl"
    :phone2-intl="$phone2Intl"
    :whatsapp-intl="$whatsappIntl"
    :whatsapp-message="$whatsappMessage"
/>

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
