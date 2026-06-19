<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Sozo Habitat Agent</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>


<body class="bg-slate-100">


<div class="flex min-h-screen">


    <x-agent-sidebar />



    <main class="flex-1 p-10">


        @yield('content')


    </main>


</div>


</body>

</html>