@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-[#F8F9FB] px-6 py-10">

    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-10">
            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Administration
                </p>

                <h1 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    Gestion des biens
                </h1>
            </div>

            <a href="{{ route('admin.properties.create') }}"
               class="rounded-full bg-[#C89B3C] px-6 py-3 font-bold text-white hover:bg-[#A87F2E] transition">
                Ajouter un bien
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex flex-col gap-6">

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.properties.index') }}"
                       class="rounded-full px-5 py-2 font-bold {{ request('filter') ? 'bg-slate-100 text-[#0A2E5D]' : 'bg-[#0A2E5D] text-white' }}">
                        Tous les biens
                    </a>

                    <a href="{{ route('admin.properties.index', ['filter' => 'vente']) }}"
                       class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'vente' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Ventes
                    </a>

                    <a href="{{ route('admin.properties.index', ['filter' => 'location']) }}"
                       class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'location' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Locations
                    </a>

                    <a href="{{ route('admin.properties.index', ['filter' => 'terrain']) }}"
                       class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'terrain' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Terrains
                    </a>

                    <a href="{{ route('admin.properties.index', ['filter' => 'featured']) }}"
                       class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'featured' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Vedettes
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.properties.index') }}" class="flex flex-col md:flex-row gap-3">
                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Rechercher un bien par titre, ville, commune, type..."
                        class="w-full rounded-2xl border border-slate-200 px-5 py-4"
                    >

                    <button
                        type="submit"
                        class="rounded-2xl bg-[#C89B3C] px-8 py-4 font-bold text-white hover:bg-[#A87F2E] transition"
                    >
                        Rechercher
                    </button>
                </form>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[#0A2E5D]">
                        <tr>
                            <th class="p-5">Titre</th>
                            <th class="p-5">Ville</th>
                            <th class="p-5">Type</th>
                            <th class="p-5">Transaction</th>
                            <th class="p-5">Prix</th>
                            <th class="p-5">Vedette</th>
                            <th class="p-5">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($properties as $property)
                            <tr class="border-t border-slate-100">
                                <td class="p-5 font-bold text-[#0A2E5D]">
                                    {{ $property->title }}
                                </td>

                                <td class="p-5 text-slate-600">
                                    {{ $property->city }}
                                </td>

                                <td class="p-5 text-slate-600">
                                    {{ ucfirst(str_replace('_', ' ', $property->type)) }}
                                </td>

                                <td class="p-5 text-slate-600">
                                    {{ ucfirst($property->transaction) }}
                                </td>

                                <td class="p-5 font-bold text-[#C89B3C]">
                                    {{ number_format($property->price, 0, ',', ' ') }} FCFA
                                </td>

                                <td class="p-5">
                                    <form method="POST" action="{{ route('admin.properties.toggle-featured', $property) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="rounded-full px-4 py-2 text-sm font-bold transition
                                            {{ $property->featured
                                                ? 'bg-[#C89B3C] text-white hover:bg-[#A87F2E]'
                                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                                        >
                                            {{ $property->featured ? 'Vedette' : 'Non' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="p-5">
                                    <div class="flex flex-wrap gap-4 items-center">
                                        <a href="{{ route('properties.show', $property) }}"
                                           class="font-bold text-green-700 hover:text-green-900">
                                            Voir
                                        </a>

                                        <a href="{{ route('admin.properties.edit', $property) }}"
                                           class="font-bold text-[#0A2E5D] hover:text-[#C89B3C]">
                                            Modifier
                                        </a>

                                        <form
                                            action="{{ route('admin.properties.destroy', $property) }}"
                                            method="POST"
                                            onsubmit="return confirm('Supprimer ce bien ?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="font-bold text-red-600 hover:text-red-800"
                                            >
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-500">
                                    Aucun bien trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $properties->links() }}
            </div>

        </div>

    </div>

</section>

@endsection