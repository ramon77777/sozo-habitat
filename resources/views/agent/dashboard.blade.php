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

    <div class="mt-8 min-w-0 rounded-3xl bg-white p-4 shadow sm:p-6 lg:mt-12">
        <h2 class="mb-5 text-xl font-black text-[#0A2E5D] sm:mb-6 sm:text-2xl">
            Mes derniers biens
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[620px] w-full">
                <thead>
                    <tr class="border-b text-left">
                        <th class="p-3">Titre</th>
                        <th class="p-3">Ville</th>
                        <th class="p-3">Prix</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($properties as $property)
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
                    @empty
                        <tr>
                            <td colspan="3" class="p-5 text-center text-slate-400">
                                Aucun bien attribué
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 min-w-0 rounded-3xl bg-white p-4 shadow sm:p-6 lg:mt-10">
        <h2 class="mb-5 text-xl font-black text-[#0A2E5D] sm:mb-6 sm:text-2xl">
            Mes clients
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[560px] w-full">
                <thead>
                    <tr class="border-b text-left">
                        <th class="p-3">Nom</th>
                        <th class="p-3">Téléphone</th>
                        <th class="p-3">Statut</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($prospects as $prospect)
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
                    @empty
                        <tr>
                            <td colspan="3" class="p-5 text-center text-slate-400">
                                Aucun client
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
