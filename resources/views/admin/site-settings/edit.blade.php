@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-[#F8F9FB] py-12 px-6">

    <div class="max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-10">

            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Administration
                </p>

                <h1 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    Paramètres du site
                </h1>
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition"
            >
                Retour Dashboard
            </a>

        </div>

        @if(session('success'))

            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                {{ session('success') }}
            </div>

        @endif

        @if ($errors->any())

            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-5 text-red-700">

                <p class="font-bold mb-3">
                    Veuillez corriger les erreurs suivantes :
                </p>

                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <div class="bg-white rounded-3xl shadow-xl p-10">

            <form
                action="{{ route('admin.site-settings.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                {{-- Branding --}}

                <h2 class="text-2xl font-black text-[#0A2E5D] mb-6">
                    Branding
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">
                            Nom du site
                        </label>

                        <input
                            type="text"
                            name="site_name"
                            value="{{ old('site_name', $settings->site_name) }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Logo
                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >

                        @if($settings->logo)

                            <img
                                src="{{ asset('images/settings/' . $settings->logo) }}"
                                class="h-20 mt-4 rounded-xl"
                                alt=""
                            >

                        @endif
                    </div>

                </div>

                {{-- Coordonnées --}}

                <h2 class="text-2xl font-black text-[#0A2E5D] mt-12 mb-6">
                    Coordonnées
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $settings->email) }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            WhatsApp
                        </label>

                        <input
                            type="text"
                            name="whatsapp"
                            value="{{ old('whatsapp', $settings->whatsapp) }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Téléphone 1
                        </label>

                        <input
                            type="text"
                            name="phone_1"
                            value="{{ old('phone_1', $settings->phone_1) }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">
                            Téléphone 2
                        </label>

                        <input
                            type="text"
                            name="phone_2"
                            value="{{ old('phone_2', $settings->phone_2) }}"
                            class="w-full border border-slate-200 rounded-xl p-4"
                        >
                    </div>

                </div>

                <div class="mt-6">
                    <label class="block mb-2 font-semibold">
                        Adresse
                    </label>

                    <textarea
                        name="address"
                        rows="3"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    >{{ old('address', $settings->address) }}</textarea>
                </div>

                {{-- Réseaux sociaux --}}

                <h2 class="text-2xl font-black text-[#0A2E5D] mt-12 mb-6">
                    Réseaux sociaux
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <input
                        type="url"
                        name="facebook"
                        value="{{ old('facebook', $settings->facebook) }}"
                        placeholder="Facebook"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="instagram"
                        value="{{ old('instagram', $settings->instagram) }}"
                        placeholder="Instagram"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="linkedin"
                        value="{{ old('linkedin', $settings->linkedin) }}"
                        placeholder="LinkedIn"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="tiktok"
                        value="{{ old('tiktok', $settings->tiktok) }}"
                        placeholder="TikTok"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                    <input
                        type="url"
                        name="youtube"
                        value="{{ old('youtube', $settings->youtube) }}"
                        placeholder="YouTube"
                        class="border border-slate-200 rounded-xl p-4"
                    >

                </div>

                {{-- SEO --}}

                <h2 class="text-2xl font-black text-[#0A2E5D] mt-12 mb-6">
                    SEO
                </h2>

                <div class="space-y-6">

                    <input
                        type="text"
                        name="meta_title"
                        value="{{ old('meta_title', $settings->meta_title) }}"
                        placeholder="Titre SEO"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    >

                    <textarea
                        name="meta_description"
                        rows="4"
                        placeholder="Description SEO"
                        class="w-full border border-slate-200 rounded-xl p-4"
                    >{{ old('meta_description', $settings->meta_description) }}</textarea>

                </div>

                <button
                    type="submit"
                    class="mt-10 rounded-full bg-[#C89B3C] px-8 py-4 font-bold text-white hover:bg-[#A87F2E] transition"
                >
                    Enregistrer les paramètres
                </button>

            </form>

        </div>

    </div>

</section>

@endsection