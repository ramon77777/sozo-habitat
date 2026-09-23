<x-guest-layout>
    <section class="rounded-[2rem] border border-white bg-white p-6 shadow-[0_24px_70px_rgba(15,23,42,0.10)] sm:p-9">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.24em] text-[#C89B3C]">
                Bienvenue
            </p>

            <h2 class="mt-3 text-3xl font-black tracking-tight text-[#0A2E5D] sm:text-4xl">
                Connexion
            </h2>

            <p class="mt-3 leading-7 text-slate-500">
                Accès réservé aux administrateurs et agents Sozo Habitat.
            </p>
        </div>

        @if(session('status'))
            <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                Les informations de connexion sont incorrectes. Veuillez réessayer.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
            @csrf

            <label class="block">
                <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Adresse e-mail</span>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="vous@sozohabitat.com"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-5 py-4 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#C89B3C] focus:ring-4 focus:ring-[#C89B3C]/10"
                >

                @if($errors->has('email'))
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $errors->first('email') }}</p>
                @endif
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-[#0A2E5D]">Mot de passe</span>

                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Votre mot de passe"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-5 py-4 pr-14 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#C89B3C] focus:ring-4 focus:ring-[#C89B3C]/10"
                    >

                    <button
                        type="button"
                        id="togglePassword"
                        class="absolute inset-y-0 right-0 flex w-14 items-center justify-center text-slate-400 transition hover:text-[#0A2E5D]"
                        aria-label="Afficher le mot de passe"
                    >
                        <svg id="eyeIcon" viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                            <circle cx="12" cy="12" r="2.5"/>
                        </svg>
                    </button>
                </div>

                @if($errors->has('password'))
                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $errors->first('password') }}</p>
                @endif
            </label>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-slate-300 text-[#0A2E5D] focus:ring-[#C89B3C]"
                    >
                    Se souvenir de moi
                </label>

                @if(Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm font-bold text-[#0A2E5D] transition hover:text-[#C89B3C]"
                    >
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <button
                type="submit"
                class="sozo-shine inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#C89B3C] px-6 py-4 font-black text-white shadow-lg shadow-[#C89B3C]/20 transition hover:-translate-y-0.5 hover:bg-[#B7892E]"
            >
                Se connecter
                <span aria-hidden="true">→</span>
            </button>
        </form>

        <div class="mt-7 flex items-start gap-3 rounded-2xl bg-[#F7F8FA] p-4">
            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#0A2E5D] text-[#DDB85F]">
                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3M6 10h12v10H6V10Z"/>
                </svg>
            </span>
            <p class="text-sm leading-6 text-slate-500">
                Après connexion, vous serez automatiquement dirigé vers votre espace
                <strong class="text-[#0A2E5D]">administrateur</strong> ou
                <strong class="text-[#0A2E5D]">agent</strong>.
            </p>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('togglePassword');
            const input = document.getElementById('password');

            if (!button || !input) return;

            button.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-label', isPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
            });
        });
    </script>
</x-guest-layout>