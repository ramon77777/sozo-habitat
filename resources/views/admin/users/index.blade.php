@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-[#F8F9FB] px-6 py-12">

    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-10">
            <div>
                <a href="{{ route('admin.dashboard') }}"
                   class="font-bold text-[#0A2E5D] hover:text-[#C89B3C]">
                    ← Retour au dashboard
                </a>

                <h1 class="text-4xl font-black text-[#0A2E5D] mt-4">
                    Gestion des utilisateurs
                </h1>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="rounded-full bg-[#C89B3C] px-6 py-3 font-bold text-white hover:bg-[#A87F2E] transition">
                Ajouter un utilisateur
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-100 text-[#0A2E5D]">
                        <tr>
                            <th class="p-5">Nom</th>
                            <th class="p-5">Email</th>
                            <th class="p-5">Rôle</th>
                            <th class="p-5">Date création</th>
                            <th class="p-5">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-t border-slate-100">
                                <td class="p-5 font-bold text-[#0A2E5D]">
                                    {{ $user->name }}
                                </td>

                                <td class="p-5 text-slate-600">
                                    {{ $user->email }}
                                </td>

                                <td class="p-5">
                                    <span class="rounded-full px-4 py-2 text-sm font-bold
                                        {{ $user->role === 'admin' ? 'bg-[#0A2E5D] text-white' : 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td class="p-5 text-slate-500">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td class="p-5">
                                    <div class="flex flex-wrap gap-4 items-center">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="font-bold text-[#0A2E5D] hover:text-[#C89B3C]">
                                            Modifier
                                        </a>

                                        <form
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Supprimer cet utilisateur ?')"
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
                                <td colspan="5" class="p-8 text-center text-slate-500">
                                    Aucun utilisateur trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>

</section>

@endsection