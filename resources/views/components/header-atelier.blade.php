@php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$role = optional($user?->role)?->name ?? null;

// Couleur du nom de l'utilisateur selon le rôle
$userRoleColor = match($role) {
    'admin' => '#8B0000',       // rouge foncé
    'technician' => '#006400',  // vert foncé
    'client' => '#00008B',      // bleu foncé
    default => '#442b1f',       // couleur par défaut
};
@endphp

<header class="w-full fixed top-0 left-0 z-50 shadow-lg border-b border-gray-300"
        style="height: 10vh; background-color: #d0ba9b; color: #442b1f;">
    <div class="h-full flex items-center justify-between px-8">
        {{-- LOGO / TITRE --}}
        <div class="text-3xl font-bold tracking-wide drop-shadow-sm">
            <span class="px-3 py-1 rounded-lg bg-white shadow-md">
                www.Atelier404.com
            </span>
        </div>

        {{-- BREADCRUMB --}}
        <div class="text-lg font-semibold">
            {{ $breadcrumb ?? '' }}
        </div>

        {{-- MENU DROIT --}}
        <div class="flex items-center gap-4">
            @if($user)
                {{-- Nom utilisateur avec couleur selon le rôle --}}
                <span class="font-semibold text-xl" style="color: {{ $userRoleColor }} !important;">
                    {{ $user->name }}
                </span>

                <div class="relative" id="dropdown-container">
                    <button id="dropdown-button" class="px-4 py-2 rounded-md bg-white border shadow-sm hover:shadow-md transition">
                        ☰
                    </button>

                    <div id="dropdown-menu" class="absolute right-0 mt-2 bg-white shadow-xl rounded-lg w-56 overflow-hidden border hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-gray-100 font-medium">Profil</a>

                        @if($role === 'admin')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Tableau de bord</a>
                            <a href="{{ route('interventions.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Toutes les interventions</a>
                            <a href="{{ route('clients.index') }}" class="block px-4 py-3 hover:bg-gray-100">Gestion des clients</a>
                        @endif

                        @if($role === 'technician')
                            <a href="{{ route('interventions.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Mes interventions</a>
                        @endif

                        @if($role === 'client')
                            <a href="{{ route('client.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Mes réparations</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-3 hover:bg-gray-100 font-medium">Déconnexion</button>
                        </form>
                    </div>
                </div>
            @else
                {{-- Boutons Se connecter / S'inscrire --}}
                <a href="{{ route('login') }}" class="px-4 py-2 bg-[#442b1f] text-[#d0ba9b] font-semibold rounded hover:opacity-90">Se connecter</a>
                <a href="{{ route('register') }}" class="px-4 py-2 border border-[#442b1f] text-[#442b1f] font-semibold rounded hover:bg-[#442b1f] hover:text-[#d0ba9b]">S'inscrire</a>
            @endif
        </div>
    </div>
</header>

{{-- SPACER --}}
<div style="height: 10vh;"></div>

<script>
    const dropdownContainer = document.getElementById('dropdown-container');
    const dropdownMenu = document.getElementById('dropdown-menu');
    const dropdownButton = document.getElementById('dropdown-button');

    let menuTimeout;

    dropdownContainer?.addEventListener('mouseenter', () => {
        clearTimeout(menuTimeout);
        dropdownMenu.classList.remove('hidden');
    });

    dropdownContainer?.addEventListener('mouseleave', () => {
        menuTimeout = setTimeout(() => {
            dropdownMenu.classList.add('hidden');
        }, 200);
    });

    dropdownButton?.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });
</script>
