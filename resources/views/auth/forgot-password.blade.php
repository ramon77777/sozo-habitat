<x-guest-layout>
    <section class="rounded-[2rem] border border-white bg-white p-6 shadow-[0_24px_70px_rgba(15,23,42,0.10)] sm:p-9">
        <p class="text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
            Accès équipe
        </p>

        <h2 class="mt-3 text-3xl font-black tracking-tight text-[#0A2E5D]">
            Mot de passe oublié ?
        </h2>

        <p class="mt-3 leading-7 text-slate-500">
            Saisissez votre adresse e-mail. Si elle correspond à un compte Sozo Habitat, vous recevrez un lien de réinitialisation.
        </p>

        @if(session('status'))
            <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-8">
            @csrf

            <label class="block">
                <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Adresse e-mail</span>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="vous@sozohabitat.com"
                    class="w-full rounded-2xl border border-slate-200 px-5 py-4 outline-none transition focus:border-[#C89B3C] focus:ring-4 focus:ring-[#C89B3C]/10"
                >

                @if($errors->has('email'))
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </label>

            <button
                type="submit"
                class="mt-6 inline-flex w-full items-center justify-center rounded-2xl bg-[#C89B3C] px-6 py-4 font-black text-white transition hover:bg-[#B7892E]"
            >
                Envoyer le lien de réinitialisation
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