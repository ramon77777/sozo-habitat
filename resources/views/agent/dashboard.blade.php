@extends('layouts.agent')

@section('content')

<div class="min-w-0">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-black leading-tight text-[#0A2E5D] sm:text-4xl">
            Bonjour {{ auth()->user()->name }}
        </h1>

        <p class="text-sm text-slate-500 sm:text-base">
            Espace agent Sozo Habitat
        </p>
    </div>

    <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-5 lg:mt-10 lg:grid-cols-3 lg:gap-6">
        <div class="min-w-0 rounded-2xl bg-white p-4 shadow sm:rounded-3xl sm:p-6">
            <h3 class="font-bold">
                Mes biens
            </h3>

            <p class="mt-3 text-4xl font-black text-[#0A2E5D] sm:text-5xl">
                {{ $totalProperties }}
            </p>

            <a href="{{ route('agent.properties.index') }}"
                class="mt-3 inline-block text-sm font-semibold text-blue-600">
                Voir mes biens →
            </a>
        </div>

        <div class="min-w-0 rounded-2xl bg-white p-4 shadow sm:rounded-3xl sm:p-6">
            <h3 class="font-bold">
                Mes clients
            </h3>

            <p class="mt-3 text-4xl font-black text-[#0A2E5D] sm:text-5xl">
                {{ $totalProspects }}
            </p>

            <a href="{{ route('agent.prospects.index') }}"
                class="mt-3 inline-block text-sm font-semibold text-blue-600">
                Voir mes clients →
            </a>
        </div>

        <div class="col-span-2 min-w-0 rounded-2xl bg-white p-4 shadow sm:rounded-3xl sm:p-6 lg:col-span-1">
            <h3 class="font-bold">
                Nouveaux contacts
            </h3>

            <p class="mt-3 text-4xl font-black text-[#C89B3C] sm:text-5xl">
                {{ $newProspects }}
            </p>
        </div>
    </div>

    <section class="mt-8 min-w-0 rounded-3xl bg-white p-4 shadow sm:p-6 lg:mt-12">
        <div class="mb-5 flex items-center justify-between gap-3 sm:mb-6">
            <h2 class="text-xl font-black text-[#0A2E5D] sm:text-2xl">
                Mes derniers biens
            </h2>

            @if($properties->count() > 0)
                <a href="{{ route('agent.properties.index') }}"
                    class="shrink-0 text-sm font-bold text-[#0A2E5D] hover:text-[#C89B3C]">
                    Voir tout →
                </a>
            @endif
        </div>

        @if($properties->count() === 0)
            <div class="flex min-h-32 flex-col items-center justify-center rounded-2xl bg-slate-50 px-4 py-8 text-center">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-[#0A2E5D]/10 text-xl">
                    🏠
                </div>
                <p class="font-bold text-[#0A2E5D]">Aucun bien attribué</p>
                <p class="mt-1 text-sm text-slate-500">Les biens qui vous seront affectés apparaîtront ici.</p>
            </div>
        @else
            <div class="space-y-3 md:hidden">
                @foreach($properties as $property)
                    <a href="{{ route('properties.show', $property) }}"
                        class="block rounded-2xl border border-slate-100 bg-slate-50 p-4 transition hover:border-[#C89B3C]/50 hover:bg-white">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate font-black text-[#0A2E5D]">
                                    {{ $property->title }}
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $property->city }}
                                </p>
                            </div>

                            <span class="shrink-0 rounded-full bg-[#C89B3C]/10 px-3 py-1 text-xs font-bold text-[#9C731F]">
                                {{ number_format($property->price,0,' ',' ') }} FCFA
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-[620px] w-full">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="p-3">Titre</th>
                            <th class="p-3">Ville</th>
                            <th class="p-3">Prix</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($properties as $property)
                            <tr class="border-b">
                                <td class="p-3 font-bold">
                                    {{ $property->title }}
                                </td>

                                <td class="p-3">
                                    {{ $property->city }}
                                </td>

                                <td class="p-3">
                                    {{ number_format($property->price,0,' ',' ') }} FCFA
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <section class="mt-8 min-w-0 rounded-3xl bg-white p-4 shadow sm:p-6 lg:mt-10">
        <div class="mb-5 flex items-center justify-between gap-3 sm:mb-6">
            <h2 class="text-xl font-black text-[#0A2E5D] sm:text-2xl">
                Mes clients
            </h2>

            @if($prospects->count() > 0)
                <a href="{{ route('agent.prospects.index') }}"
                    class="shrink-0 text-sm font-bold text-[#0A2E5D] hover:text-[#C89B3C]">
                    Voir tout →
                </a>
            @endif
        </div>

        @if($prospects->count() === 0)
            <div class="flex min-h-32 flex-col items-center justify-center rounded-2xl bg-slate-50 px-4 py-8 text-center">
                <div class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-[#0A2E5D]/10 text-xl">
                    👤
                </div>
                <p class="font-bold text-[#0A2E5D]">Aucun client</p>
                <p class="mt-1 text-sm text-slate-500">Vos prospects et clients suivis apparaîtront ici.</p>
            </div>
        @else
            <div class="space-y-3 md:hidden">
                @foreach($prospects as $prospect)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="truncate font-black text-[#0A2E5D]">
                                    {{ $prospect->name }}
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ $prospect->phone }}
                                </p>
                            </div>

                            <span class="shrink-0 rounded-full bg-white px-3 py-1 text-xs font-bold text-slate-600 shadow-sm">
                                {{ $prospect->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="min-w-[560px] w-full">
                    <thead>
                        <tr class="border-b text-left">
                            <th class="p-3">Nom</th>
                            <th class="p-3">Téléphone</th>
                            <th class="p-3">Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prospects as $prospect)
                            <tr class="border-b">
                                <td class="p-3">
                                    {{ $prospect->name }}
                                </td>

                                <td class="p-3">
                                    {{ $prospect->phone }}
                                </td>

                                <td class="p-3">
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1">
                                        {{ $prospect->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>

@endsection
