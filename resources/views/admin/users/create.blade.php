@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-[#F8F9FB] px-6 py-12">

    <div class="max-w-4xl mx-auto">

        <div class="mb-10">
            <a href="{{ route('admin.users.index') }}"
               class="font-bold text-[#0A2E5D] hover:text-[#C89B3C]">
                ← Retour aux utilisateurs
            </a>

            <h1 class="text-4xl font-black text-[#0A2E5D] mt-4">
                Ajouter un utilisateur
            </h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-700">
                <p class="font-bold mb-3">Veuillez corriger les erreurs suivantes :</p>

                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl p-10">

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">
                            Nom
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                            required
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                            required
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Mot de passe
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full border border-slate-200 rounded-xl p-4"
                            required
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Confirmer le mot de passe
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border border-slate-200 rounded-xl p-4"
                            required
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Rôle
                        </label>

                        <select
                            name="role"
                            class="w-full border border-slate-200 rounded-xl p-4"
                            required
                        >
                            <option value="admin" @selected(old('role') === 'admin')>
                                Admin
                            </option>

                            <option value="agent" @selected(old('role') === 'agent')>
                                Agent
                            </option>
                        </select>
                    </div>

                </div>

                <button
                    type="submit"
                    class="mt-10 rounded-full bg-[#C89B3C] px-8 py-4 font-bold text-white hover:bg-[#A87F2E] transition"
                >
                    Créer l’utilisateur
                </button>

            </form>

        </div>

    </div>

</section>

@endsection