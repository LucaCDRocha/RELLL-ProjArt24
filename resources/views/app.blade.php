<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'RELLL') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <script>
        JSON.parse(localStorage.getItem('darkMode')) ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
    </script>
</head>

<body class="font-sans antialiased dark:bg-gray-800 dark:text-white">
    @inertia
</body>

</html>
