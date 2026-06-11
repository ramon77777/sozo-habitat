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
                    Biens vedettes
                </h1>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition">
                Retour Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-2xl font-black text-[#0A2E5D]">
                    Liste des biens mis en vedette
                </h2>

                <a href="{{ route('admin.dashboard') }}"
                   class="rounded-full bg-[#C89B3C] px-5 py-3 font-bold text-white hover:bg-[#A87F2E] transition">
                    Gérer les biens
                </a>
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
                            <th class="p-5">Date vedette</th>
                            <th class="p-5">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($featuredProperties as $property)
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

                                <td class="p-5 text-slate-500">
                                    {{ $property->featured_at ? $property->featured_at->format('d/m/Y H:i') : '-' }}
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

                                        <form method="POST" action="{{ route('admin.properties.toggle-featured', $property) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="font-bold text-red-600 hover:text-red-800"
                                            >
                                                Retirer
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-500">
                                    Aucun bien en vedette pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-100">
                {{ $featuredProperties->links() }}
            </div>

        </div>

    </div>

</section>

@endsection