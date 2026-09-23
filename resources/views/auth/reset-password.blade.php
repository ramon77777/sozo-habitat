<x-guest-layout>
    <section class="rounded-[2rem] border border-white bg-white p-6 shadow-[0_24px_70px_rgba(15,23,42,0.10)] sm:p-9">
        <p class="text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
            Sécurité
        </p>

        <h2 class="mt-3 text-3xl font-black tracking-tight text-[#0A2E5D]">
            Nouveau mot de passe
        </h2>

        <p class="mt-3 leading-7 text-slate-500">
            Choisissez un nouveau mot de passe sécurisé pour votre compte Sozo Habitat.
        </p>

        <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <label class="block">
                <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Adresse e-mail</span>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-4 focus:ring-[#C89B3C]/10"
                >

                @if($errors->has('email'))
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Nouveau mot de passe</span>

                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-4 focus:ring-[#C89B3C]/10"
                >

                @if($errors->has('password'))
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $errors->first('password') }}</p>
                @endif
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Confirmer le mot de passe</span>

                <input
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-4 focus:ring-[#C89B3C]/10"
                >
            </label>

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-2xl bg-[#C89B3C] px-6 py-4 font-black text-white transition hover:bg-[#B7892E]"
            >
                Enregistrer le nouveau mot de passe
            </button>
        </form>

        <a
            href="{{ route('login') }}"
            class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-[#0A2E5D] transition hover:text-[#C89B3C]"
        >
            ← Retour à la connexion
        </a>
    </section>
</x-guest-layout>