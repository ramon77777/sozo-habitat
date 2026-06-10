@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-6">

    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}"
               class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">
                ← Retour au dashboard
            </a>

            <h1 class="text-4xl font-black text-[#0A2E5D] mt-4">
                Demandes de visite
            </h1>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead class="bg-slate-100 text-[#0A2E5D]">
                    <tr>
                        <th class="p-4">Bien</th>
                        <th class="p-4">Nom</th>
                        <th class="p-4">Téléphone</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Statut</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($inquiries as $inquiry)

                        <tr class="border-t border-slate-100">

                            <td class="p-4 font-semibold text-[#0A2E5D]">
                                {{ $inquiry->property->title ?? 'Bien supprimé' }}
                            </td>

                            <td class="p-4 font-semibold">
                                {{ $inquiry->name }}
                            </td>

                            <td class="p-4">
                                <a href="tel:{{ $inquiry->phone }}"
                                   class="text-[#0A2E5D] font-bold hover:text-[#C89B3C]">
                                    {{ $inquiry->phone }}
                                </a>
                            </td>

                            <td class="p-4">
                                @if($inquiry->email)
                                    <a href="mailto:{{ $inquiry->email }}"
                                       class="text-[#0A2E5D] hover:text-[#C89B3C]">
                                        {{ $inquiry->email }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Non renseigné</span>
                                @endif
                            </td>

                            <td class="p-4 text-slate-600">
                                {{ $inquiry->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="p-4">
                                @if($inquiry->is_processed)
                                    <span class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-bold">
                                        Traité
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">
                                        Nouveau
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">
                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('admin.property-inquiries.show', $inquiry) }}"
                                        class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 font-semibold hover:bg-slate-300"
                                    >
                                        Voir
                                    </a>

                                    <form
                                        action="{{ route('admin.property-inquiries.toggle', $inquiry) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-xl bg-[#0A2E5D] text-white font-semibold hover:bg-[#071F3F]"
                                        >
                                            {{ $inquiry->status === 'new' ? 'Traiter' : 'Réouvrir' }}
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500">
                                Aucune demande enregistrée
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <div class="mt-6">
        {{ $inquiries->links() }}
    </div>

</div>

@endsection