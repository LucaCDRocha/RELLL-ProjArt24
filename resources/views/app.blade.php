<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'RELLL') }}</title>

    <!-- Manifest -->
    <link rel="manifest" href="/manifest.webmanifest" />

    <!-- Meta données -->
    <meta name="title" content="VaudSentiers">
    <meta name="description" content="Une application web de sentiers culturels">
    <meta name="author" content="RELLL">
    <meta name="keywords" content="sentiers, culture, vaud, suisse, randonnée, balade, patrimoine, histoire, nature">

    <!-- Open Graph -->
    <meta property="og:title" content="VaudSentiers" />
    <meta property="og:description" content="Une application web de sentiers culturels" />
    <meta property="og:image" content="public/img/logo/Logo_RGB_grand.png" />
    <meta property="og:url" content="vaudsentiers.ch" />


    <!-- Logo -->
    <link rel="icon" href="/img/logo/Logo_RGB_petit.png" type="image/png" sizes="64x64">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <script>
        JSON.parse(localStorage.getItem('darkMode')) ? document.documentElement.classList.add('dark') : document
            .documentElement.classList.remove('dark');
    </script>

</head>

<body>
    @inertia
</body>

</html>
