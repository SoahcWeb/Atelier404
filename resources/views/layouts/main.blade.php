<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Atelier 404' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col">

    {{-- HEADER GLOBAL --}}
    <x-header-atelier />

    {{-- CONTENU DE LA PAGE --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER GLOBAL --}}
    <x-footer-atelier />

</body>
</html>
