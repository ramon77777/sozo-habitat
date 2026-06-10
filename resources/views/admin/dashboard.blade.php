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
                    Tableau de bord
                </h1>
            </div>

            <a href="/"
               class="rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition">
                Voir le site
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($newInquiries > 0)

            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-6 shadow">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h3 class="text-xl font-black text-red-700">
                            🔔 Nouvelles demandes de visite
                        </h3>

                        <p class="mt-2 text-red-600">
                            Vous avez actuellement
                            <strong>{{ $newInquiries }}</strong>
                            demande(s) à traiter.
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.property-inquiries.index') }}"
                        class="rounded-full bg-red-600 px-5 py-3 font-bold text-white hover:bg-red-700 transition"
                    >
                        Voir les demandes
                    </a>

                </div>

            </div>

        @endif

        <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Total biens</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $totalProperties }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Ventes</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $saleProperties }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Locations</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $rentProperties }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Terrains</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $landProperties }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Demandes</p>
                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $totalInquiries }}
                </h2>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow">
                <p class="text-slate-500">Nouvelles</p>
                <h2 class="text-4xl font-black text-green-600 mt-3">
                    {{ $newInquiries }}
                </h2>
            </div>

        </div>

        <div class="mt-10 bg-white rounded-3xl shadow overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex flex-col gap-6">

                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <h2 class="text-2xl font-black text-[#0A2E5D]">
                        Gestion des biens
                    </h2>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.property-inquiries.index') }}"
                        class="rounded-full bg-[#0A2E5D] px-5 py-3 font-bold text-white hover:bg-[#071F3F] transition">
                            Voir les demandes
                        </a>

                        <a href="{{ route('admin.properties.create') }}"
                        class="rounded-full bg-[#C89B3C] px-5 py-3 font-bold text-white hover:bg-[#A87F2E] transition">
                            Ajouter un bien
                        </a>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                    class="rounded-full px-5 py-2 font-bold {{ request('filter') ? 'bg-slate-100 text-[#0A2E5D]' : 'bg-[#0A2E5D] text-white' }}">
                        Tous les biens
                    </a>

                    <a href="{{ route('admin.dashboard', ['filter' => 'vente']) }}"
                    class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'vente' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Ventes
                    </a>

                    <a href="{{ route('admin.dashboard', ['filter' => 'location']) }}"
                    class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'location' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Locations
                    </a>

                    <a href="{{ route('admin.dashboard', ['filter' => 'terrain']) }}"
                    class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'terrain' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Terrains
                    </a>

                    <a href="{{ route('admin.dashboard', ['filter' => 'featured']) }}"
                    class="rounded-full px-5 py-2 font-bold {{ request('filter') === 'featured' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-[#0A2E5D]' }}">
                        Vedettes
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col md:flex-row gap-3">
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
                                    <div class="flex flex-wrap gap-4 items-center">

                                        <a
                                            href="{{ route('properties.show', $property) }}"
                                            target="_blank"
                                            class="text-green-700 font-bold hover:text-green-900"
                                        >
                                            Voir
                                        </a>

                                        <a
                                            href="{{ route('admin.properties.edit', $property) }}"
                                            class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]"
                                        >
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
                                <td colspan="6" class="p-8 text-center text-slate-500">
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