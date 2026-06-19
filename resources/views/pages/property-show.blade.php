@extends('layouts.app')

@section('seo')

<x-seo

    :title="$property->title 
        . ' - ' 
        . ucfirst($property->type) 
        . ' ' 
        . ucfirst($property->transaction)
        . ' à '
        . $property->city
        . ' | Sozo Habitat Côte d\'Ivoire'"
    
    :description="'Découvrez ' 
        . $property->title 
        . ', un(e) '
        . $property->type
        . ' disponible en '
        . $property->transaction
        . ' à '
        . $property->city
        . '. Sozo Habitat vous accompagne dans vos projets immobiliers partout en Côte d\'Ivoire.'"

    :image="$property->images->first()
        ? asset('images/properties/gallery/' . $property->images->first()->image_path)
        : asset('images/logo.png')"

/>


@php

$propertySchema = [

    "@context" => "https://schema.org",

    "@type" => "RealEstateListing",

    "name" => $property->title,

    "description" => $property->description,

    "image" => $property->images->first()
        ? asset('images/properties/gallery/' . $property->images->first()->image_path)
        : asset('images/logo.png'),


    "offers" => [

        "@type" => "Offer",

        "price" => $property->price,

        "priceCurrency" => "XOF",

        "availability" => "https://schema.org/InStock"

    ],


    "address" => [

        "@type" => "PostalAddress",

        "addressLocality" => $property->city,

        "addressCountry" => "CI"

    ],


    "url" => url()->current()

];

@endphp


<script type="application/ld+json">

{!! json_encode(
    $propertySchema,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
) !!}

</script>


@endsection



@section('content')

<section class="bg-[#F8F9FB] min-h-screen py-20">

    <div class="max-w-7xl mx-auto px-6">

        @php
            $photos = collect();

            if ($property->main_image) {
                $photos->push(asset('images/properties/' . $property->main_image));
            }

            foreach ($property->images as $image) {
                $photos->push(asset('images/properties/gallery/' . $image->image_path));
            }
        @endphp

        <div class="grid lg:grid-cols-2 gap-12 items-start">

            {{-- Galerie photos --}}
            <div>
                <div class="relative group">
                    <img
                        id="mainImage"
                        src="{{ $photos->first() }}"
                        class="w-full h-[520px] rounded-3xl shadow-lg object-cover cursor-zoom-in"
                        alt="{{ $property->title }} - {{ $property->city }} - Sozo Habitat Côte d'Ivoire"
                        loading="eager"
                        onclick="openGallery(currentIndex)"
                    >

                    @if($photos->count() > 1)
                        <button
                            type="button"
                            onclick="previousImage()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-white/90 text-[#0A2E5D] font-black shadow hover:bg-white"
                        >
                            ‹
                        </button>

                        <button
                            type="button"
                            onclick="nextImage()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-white/90 text-[#0A2E5D] font-black shadow hover:bg-white"
                        >
                            ›
                        </button>

                        <div class="absolute bottom-4 right-4 rounded-full bg-black/70 px-4 py-2 text-white font-bold text-sm">
                            <span id="photoCounter">1</span> / {{ $photos->count() }}
                        </div>
                    @endif
                </div>

                @if($photos->count() > 1)
                    <div class="grid grid-cols-4 gap-3 mt-4">
                        @foreach($photos as $index => $photo)
                            <img
                                src="{{ $photo }}"
                                data-index="{{ $index }}"
                                class="thumbnail cursor-pointer rounded-xl h-24 w-full object-cover border-2 border-transparent hover:border-[#C89B3C] hover:scale-105 transition"
                                onclick="setImage({{ $index }})"
                                alt="{{ $property->title }} - Photo {{ $index + 1 }} - {{ $property->city }}"
                                loading="lazy"
                            >
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Infos du bien --}}
            <div>
                <span class="inline-block bg-[#C89B3C] text-white px-4 py-2 rounded-full font-semibold">
                    {{ strtoupper($property->transaction) }}
                </span>

                <h1 class="text-5xl font-bold text-[#0A2E5D] mt-6">
                    {{ $property->title }}
                </h1>

                <p class="text-xl text-slate-500 mt-3">
                    {{ $property->city }}
                    @if($property->district)
                        , {{ $property->district }}
                    @endif
                </p>

                <div class="mt-8">
                    <h2 class="text-4xl font-bold text-[#C89B3C]">
                        {{ number_format($property->price, 0, ',', ' ') }} FCFA
                    </h2>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-10">

                    <div class="bg-white p-5 rounded-2xl text-center shadow">
                        <p class="font-bold text-2xl">
                            {{ $property->surface }}
                        </p>
                        <span class="text-slate-500">
                            m²
                        </span>
                    </div>

                    @if($property->type === 'terrain')

                        <div class="bg-white p-5 rounded-2xl text-center shadow">
                            <p class="font-bold text-2xl">
                                Terrain
                            </p>
                            <span class="text-slate-500">
                                Type
                            </span>
                        </div>

                        <div class="bg-white p-5 rounded-2xl text-center shadow">
                            <p class="font-bold text-2xl">
                                {{ ucfirst($property->transaction) }}
                            </p>
                            <span class="text-slate-500">
                                Transaction
                            </span>
                        </div>

                    @else

                        <div class="bg-white p-5 rounded-2xl text-center shadow">
                            <p class="font-bold text-2xl">
                                {{ $property->bedrooms ?? '-' }}
                            </p>
                            <span class="text-slate-500">
                                Chambres
                            </span>
                        </div>

                        <div class="bg-white p-5 rounded-2xl text-center shadow">
                            <p class="font-bold text-2xl">
                                {{ $property->bathrooms ?? '-' }}
                            </p>
                            <span class="text-slate-500">
                                Salles d'eau
                            </span>
                        </div>

                    @endif

                </div>

                <div class="mt-10">
                    <h3 class="text-2xl font-bold text-[#0A2E5D] mb-4">
                        Description
                    </h3>

                    <p class="text-slate-600 leading-relaxed">
                        {{ $property->description }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-4 mt-10">

                    <a
                        href="tel:+2250787463032"
                        class="bg-[#0A2E5D] hover:bg-[#071F3F] text-white px-6 py-4 rounded-xl font-semibold transition"
                    >
                        📞 07 87 46 30 32
                    </a>

                    <a
                        href="tel:+2250787587996"
                        class="bg-[#0A2E5D] hover:bg-[#071F3F] text-white px-6 py-4 rounded-xl font-semibold transition"
                    >
                        📞 07 87 58 79 96
                    </a>

                    <a
                        href="https://wa.me/2250787463032"
                        target="_blank"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-xl font-semibold transition"
                    >
                        WhatsApp
                    </a>

                    <a
                        href="/"
                        class="border border-[#0A2E5D] text-[#0A2E5D] px-6 py-4 rounded-xl font-semibold"
                    >
                        Retour
                    </a>

                </div>
            </div>

        </div>

        {{-- Vidéos --}}
        @if($property->videos->count())
            <div class="mt-24 bg-white rounded-3xl shadow-xl p-8">

                <h3 class="text-3xl font-black text-[#0A2E5D] mb-6">
                    Vidéo du bien
                </h3>

                <div class="grid md:grid-cols-2 gap-8">
                    @foreach($property->videos as $video)
                        <div class="aspect-video w-full overflow-hidden rounded-3xl bg-black shadow-lg">
                            <video
                                controls
                                preload="metadata"
                                class="h-full w-full object-contain"
                            >
                                <source
                                    src="{{ asset('videos/properties/' . $video->video_path) }}"
                                    type="video/mp4"
                                >

                                Votre navigateur ne supporte pas la vidéo.
                            </video>
                        </div>
                    @endforeach
                </div>

            </div>
        @endif

        {{-- Localisation --}}
        @if($property->latitude && $property->longitude)
            <div class="mt-16 bg-white rounded-3xl shadow-xl overflow-hidden">

                <div class="p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-3xl font-black text-[#0A2E5D]">
                            Localisation du bien
                        </h3>

                        <p class="text-slate-500 mt-2">
                            {{ $property->city }}@if($property->district), {{ $property->district }}@endif
                        </p>
                    </div>

                    <a
                        href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}"
                        target="_blank"
                        class="inline-flex items-center justify-center rounded-full bg-[#C89B3C] px-6 py-3 font-bold text-white hover:bg-[#A87F2E] transition"
                    >
                        📍 Ouvrir dans Google Maps
                    </a>
                </div>

                <iframe
                    src="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}&hl=fr&z=15&output=embed"
                    class="w-full h-[420px] border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

            </div>
        @endif

        {{-- Demande de visite --}}
        <div class="mt-16 bg-white rounded-3xl shadow-xl p-8">

            <div class="mb-8">
                <h3 class="text-3xl font-black text-[#0A2E5D]">
                    Demander une visite
                </h3>

                <p class="text-slate-500 mt-2">
                    Laissez vos coordonnées, nous vous contacterons rapidement pour ce bien.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-700">
                    <p class="font-bold mb-3">Veuillez corriger les erreurs :</p>

                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('properties.inquiries.store', $property) }}">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">Nom complet</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4"
                            required
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Téléphone</label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4"
                            required
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 font-semibold">Email optionnel</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 font-semibold">Message</label>
                        <textarea
                            name="message"
                            rows="5"
                            class="w-full rounded-2xl border border-slate-200 px-5 py-4"
                        >{{ old('message', 'Bonjour, je suis intéressé(e) par ce bien : ' . $property->title) }}</textarea>
                    </div>

                </div>

                <button
                    type="submit"
                    class="mt-8 rounded-xl bg-[#C89B3C] px-8 py-4 font-bold text-white hover:bg-[#A87F2E] transition"
                >
                    Envoyer ma demande
                </button>
            </form>

        </div>

    </div>

</section>

{{-- Modal galerie plein écran --}}
<div
    id="galleryModal"
    class="fixed inset-0 z-50 hidden bg-black/95 items-center justify-center"
>
    <button
        type="button"
        onclick="closeGallery()"
        class="absolute top-6 right-6 text-white text-4xl font-bold"
    >
        ×
    </button>

    <button
        type="button"
        onclick="previousImage()"
        class="absolute left-6 top-1/2 -translate-y-1/2 h-14 w-14 rounded-full bg-white/20 text-white text-4xl hover:bg-white/30"
    >
        ‹
    </button>

    <img
        id="modalImage"
        src="{{ $photos->first() }}"
        class="max-h-[85vh] max-w-[90vw] rounded-2xl object-contain"
        alt="{{ $property->title }} - Galerie Sozo Habitat Côte d'Ivoire"
    >

    <button
        type="button"
        onclick="nextImage()"
        class="absolute right-6 top-1/2 -translate-y-1/2 h-14 w-14 rounded-full bg-white/20 text-white text-4xl hover:bg-white/30"
    >
        ›
    </button>

    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 rounded-full bg-white/20 px-5 py-2 text-white font-bold">
        <span id="modalCounter">1</span> / {{ $photos->count() }}
    </div>
</div>

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
        thumb.classList.remove('border-[#C89B3C]');
    });

    const activeThumb = document.querySelector(`[data-index="${currentIndex}"]`);

    if (activeThumb) {
        activeThumb.classList.add('border-[#C89B3C]');
    }
}

function setImage(index) {
    currentIndex = index;
    refreshGallery();
}

function nextImage() {
    currentIndex = (currentIndex + 1) % photos.length;
    refreshGallery();
}

function previousImage() {
    currentIndex = (currentIndex - 1 + photos.length) % photos.length;
    refreshGallery();
}

function openGallery(index) {
    currentIndex = index;
    refreshGallery();

    const modal = document.getElementById('galleryModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeGallery() {
    const modal = document.getElementById('galleryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('galleryModal');

    if (event.key === 'Escape') {
        closeGallery();
    }

    if (!modal.classList.contains('hidden')) {
        if (event.key === 'ArrowRight') {
            nextImage();
        }

        if (event.key === 'ArrowLeft') {
            previousImage();
        }
    }
});

refreshGallery();
</script>

@endsection