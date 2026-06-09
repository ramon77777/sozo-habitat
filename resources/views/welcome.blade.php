<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sozo Habitat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="min-h-screen bg-slate-950 text-white">

    <nav class="flex justify-between items-center px-10 py-6">

        <h1 class="text-3xl font-bold text-amber-500">
            SOZO HABITAT
        </h1>

        <div class="flex gap-8">
            <a href="#">Accueil</a>
            <a href="#">Biens</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
        </div>

    </nav>

    <section class="flex flex-col items-center justify-center text-center h-[80vh]">

        <h1 class="text-7xl font-bold mb-6">
            Trouvez votre futur logement
        </h1>

        <p class="text-xl text-gray-300 max-w-2xl">
            Achat, location, gestion immobilière et accompagnement
            professionnel pour tous vos projets.
        </p>

        <button
            class="mt-8 bg-amber-500 hover:bg-amber-600 px-8 py-4 rounded-xl font-bold">
            Découvrir nos biens
        </button>

    </section>

</div>

</body>
</html>