<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#d0ba9b] text-[#442b1f] min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-[#d0ba9b] shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ $title ?? 'Espace Client' }}</h1>

            @php $user = Auth::user(); @endphp
            @if($user)
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-2 bg-white px-4 py-2 rounded shadow">
                        👤 {{ $user->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu hidden absolute right-0 mt-2 bg-white shadow-md rounded z-50">
                        <li>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-100">Mon Profil</a>
                        </li>
                        <li>
                            <a href="{{ route('interventions.index') }}" class="block px-4 py-2 hover:bg-gray-100">Mes interventions</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </header>

    {{-- Contenu principal --}}
    <main class="container mx-auto p-6 flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-10 text-sm text-center text-[#442b1f]">
        &copy; {{ date('Y') }} Atelier 404
    </footer>

    {{-- Script dropdown --}}
    <script>
        document.querySelectorAll('.dropdown-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const menu = button.nextElementSibling;
                menu.classList.toggle('hidden');
            });
        });

        window.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        });
    </script>

</body>
</html>
