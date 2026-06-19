<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    @yield('seo')

    @if (!View::hasSection('seo'))
        <x-seo />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <title>
        @yield('title', 'SOZO Habitat | Immobilier en Côte d’Ivoire : Villas, Maisons et Terrains')
    </title>


    <meta name="description"
      content="@yield('description', 'SOZO Habitat vous accompagne dans vos projets immobiliers en Côte d’Ivoire : achat, vente et location de villas, maisons, appartements et terrains.')">


    <meta name="keywords"
      content="immobilier Côte d'Ivoire, maison à vendre Côte d'Ivoire, villa à vendre Côte d'Ivoire, terrain à vendre Côte d'Ivoire, location appartement Côte d'Ivoire, SOZO Habitat">


    <meta property="og:title"
      content="@yield('title', 'SOZO Habitat | Immobilier en Côte d’Ivoire')">


    <meta property="og:description"
      content="@yield('description', 'SOZO Habitat vous accompagne dans vos projets immobiliers en Côte d’Ivoire.')">


    <meta property="og:type"
        content="website">


    <meta property="og:image"
        content="{{ asset('images/logo.png') }}">


    <meta name="twitter:card"
        content="summary_large_image">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#F8F9FB] text-slate-900">

    @if(request()->is('admin*'))
        <div class="flex min-h-screen">
            <x-admin-sidebar />

            <main class="flex-1 overflow-x-hidden">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
    @else
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    @endif

</body>
</html>