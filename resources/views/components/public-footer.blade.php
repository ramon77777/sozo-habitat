@props([
    'siteSettings',
    'phone1Intl' => null,
    'phone2Intl' => null,
    'whatsappIntl' => null,
    'whatsappMessage' => null,
])

@php
    $normalizeContact = function ($value, $prefixIvoryCoast = true) {
        $digits = preg_replace('/\D+/', '', (string) $value);

        if ($digits === '') {
            return null;
        }

        if ($prefixIvoryCoast && !str_starts_with($digits, '225')) {
            $digits = '225' . $digits;
        }

        return $digits;
    };

    $phone1Number = $phone1Intl ?: $normalizeContact($siteSettings->phone_1 ?? null);
    $phone2Number = $phone2Intl ?: $normalizeContact($siteSettings->phone_2 ?? null);
    $whatsappNumber = $whatsappIntl ?: $normalizeContact($siteSettings->whatsapp ?? null);

    $whatsappHref = $whatsappNumber
        ? 'https://wa.me/' . $whatsappNumber . ($whatsappMessage ? '?text=' . $whatsappMessage : '')
        : null;
@endphp

<footer id="contact" class="sozo-public-footer bg-[#04152C] px-4 pb-6 pt-10 text-white sm:px-6 sm:pb-8 sm:pt-16">
    <div class="mx-auto max-w-[1400px]">
        <div class="sozo-public-footer-grid grid grid-cols-2 gap-x-6 gap-y-8 border-b border-white/10 pb-8 sm:gap-10 sm:pb-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="sozo-public-footer-brand col-span-2 lg:col-span-2">
                <a
                    href="/"
                    class="group inline-flex transition duration-300 hover:-translate-y-0.5"
                    aria-label="Sozo Habitat - Accueil"
                >
                    <img
                        src="{{ asset('images/branding/sozo-habitat-logo-dark.svg') }}"
                        alt="Sozo Habitat - La référence en immobilier"
                        class="h-24 w-auto object-contain sm:h-36 lg:h-40"
                    >
                </a>

                <p class="mt-4 max-w-lg text-sm leading-6 text-slate-300 sm:mt-6 sm:text-base sm:leading-7">
                    Sozo Habitat vous accompagne dans l'achat, la vente et la location de biens immobiliers en Côte d'Ivoire.
                </p>

                @php
                    $socialLinks = [
                        ['Facebook', $siteSettings->facebook ?? null],
                        ['Instagram', $siteSettings->instagram ?? null],
                        ['LinkedIn', $siteSettings->linkedin ?? null],
                        ['TikTok', $siteSettings->tiktok ?? null],
                        ['YouTube', $siteSettings->youtube ?? null],
                    ];
                @endphp

                @if(collect($socialLinks)->contains(fn ($item) => filled($item[1])))
                    <div class="mt-6 flex flex-wrap gap-3">
                        @foreach($socialLinks as [$label, $url])
                            @if($url)
                                <a
                                    href="{{ $url }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="rounded-full border border-white/15 px-4 py-2 text-xs font-bold text-slate-300 transition hover:border-[#C89B3C] hover:text-[#DDB85F]"
                                >
                                    {{ $label }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="sozo-public-footer-nav">
                <h3 class="text-sm font-black uppercase tracking-[0.18em] text-[#DDB85F]">Navigation</h3>

                <div class="mt-4 space-y-2.5 text-sm font-semibold text-slate-300 sm:mt-5 sm:space-y-3">
                    <a href="/" class="block transition hover:translate-x-1 hover:text-white">Accueil</a>
                    <a href="{{ route('properties.index') }}" class="block transition hover:translate-x-1 hover:text-white">Tous les biens</a>
                    <a href="{{ route('properties.index', ['transaction' => 'vente']) }}" class="block transition hover:translate-x-1 hover:text-white">Acheter</a>
                    <a href="{{ route('properties.index', ['transaction' => 'location']) }}" class="block transition hover:translate-x-1 hover:text-white">Louer</a>
                </div>
            </div>

            <div class="sozo-public-footer-contact">
                <h3 class="text-sm font-black uppercase tracking-[0.18em] text-[#DDB85F]">Nous contacter</h3>

                <div class="mt-4 space-y-2.5 text-sm text-slate-300 sm:mt-5 sm:space-y-3">
                    @if($siteSettings->phone_1)
                        <a href="tel:+{{ $phone1Number }}" class="block transition hover:text-white">
                            {{ $siteSettings->phone_1 }}
                        </a>
                    @endif

                    @if($siteSettings->phone_2)
                        <a href="tel:+{{ $phone2Number }}" class="block transition hover:text-white">
                            {{ $siteSettings->phone_2 }}
                        </a>
                    @endif

                    @if($siteSettings->email)
                        <a href="mailto:{{ $siteSettings->email }}" class="block break-all transition hover:text-white">
                            {{ $siteSettings->email }}
                        </a>
                    @endif

                    @if($siteSettings->address)
                        <p>{{ $siteSettings->address }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="sozo-public-footer-bottom flex flex-col gap-3 pt-5 text-[11px] text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:pt-7 sm:text-xs">
            <p>© {{ date('Y') }} {{ $siteSettings->site_name ?? 'Sozo Habitat' }}. Tous droits réservés.</p>

            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 sm:gap-x-5">
                <p>Immobilier en Côte d'Ivoire.</p>

                <a
                    href="{{ route('workspace') }}"
                    class="inline-flex items-center gap-1.5 text-slate-500 transition hover:text-[#DDB85F]"
                    aria-label="Accéder à l'espace professionnel Sozo Habitat"
                >
                    <svg viewBox="0 0 24 24" fill="none" class="h-3.5 w-3.5" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3M6 10h12v10H6V10Z"/>
                    </svg>
                    Espace professionnel
                </a>
            </div>
        </div>
    </div>
</footer>

@if($whatsappHref)
    <a
        href="{{ $whatsappHref }}"
        target="_blank"
        rel="noopener"
        class="sozo-whatsapp flex h-12 w-12 items-center justify-center rounded-full bg-green-500 text-white transition hover:-translate-y-1 hover:bg-green-600 sm:h-14 sm:w-14"
        aria-label="Contacter Sozo Habitat sur WhatsApp"
    >
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 sm:h-7 sm:w-7" aria-hidden="true">
            <path d="M12.05 2a9.88 9.88 0 0 0-8.46 15.02L2.2 22l5.1-1.34A9.98 9.98 0 1 0 12.05 2Zm0 17.98a8.1 8.1 0 0 1-4.13-1.13l-.3-.18-3.02.8.81-2.95-.2-.3A8.05 8.05 0 1 1 12.05 20Zm4.42-6.04c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.19-.71-.63-1.19-1.42-1.33-1.66-.14-.24-.02-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.19-.47-.39-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.69 2.58 4.1 3.62.57.25 1.02.4 1.37.51.58.18 1.1.16 1.51.1.46-.07 1.43-.58 1.63-1.15.2-.56.2-1.05.14-1.15-.06-.1-.22-.16-.46-.28Z"/>
        </svg>
    </a>
@endif
