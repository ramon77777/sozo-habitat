@extends('layouts.app')

@section('content')

<section class="bg-[#F8F9FB] min-h-screen py-20">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-12">

            <div>
                <img
                    src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c"
                    alt="{{ $property->title }}"
                    class="w-full h-[550px] object-cover rounded-3xl shadow-xl"
                >
            </div>

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
                        {{ number_format($property->price,0,',',' ') }} FCFA
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

                </div>

                <div class="mt-10">

                    <h3 class="text-2xl font-bold text-[#0A2E5D] mb-4">
                        Description
                    </h3>

                    <p class="text-slate-600 leading-relaxed">
                        {{ $property->description }}
                    </p>

                </div>

                <div class="flex gap-4 mt-10">

                    <a
                        href="https://wa.me/2250700000000"
                        target="_blank"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-semibold transition"
                    >
                        WhatsApp
                    </a>

                    <a
                        href="/"
                        class="border border-[#0A2E5D] text-[#0A2E5D] px-8 py-4 rounded-xl font-semibold"
                    >
                        Retour
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection