@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = optional($user?->role)?->name;

    $roleColor = match($role) {
        'admin' => 'text-red-500',
        'technician' => 'text-green-500',
        'client' => 'text-blue-500',
        default => 'text-black',
    };

    $roleGlow = match($role) {
        'admin' => 'shadow-red-300/40',
        'technician' => 'shadow-green-300/40',
        'client' => 'shadow-blue-300/40',
        default => 'shadow-gray-300/40',
    };
@endphp

<header class="w-full fixed top-0 left-0 z-50 bg-gray-100 shadow-lg border-b border-gray-300"
        style="height: 10vh;">
    <div class="h-full flex items-center justify-between px-8">
        {{-- LOGO / TITRE --}}
        <div class="text-3xl font-bold tracking-wide {{ $roleColor }} drop-shadow-sm">
            <span class="px-3 py-1 rounded-lg bg-white shadow-md {{ $roleGlow }}">
                www.Atelier404.com
            </span>
        </div>

        {{-- BREADCRUMB --}}
        <div class="text-gray-700 text-lg font-semibold">
            {{ $breadcrumb ?? '' }}
        </div>

        {{-- MENU DROIT --}}
        <div class="flex items-center gap-4">
            @if($user)
                <span class="font-semibold text-xl {{ $roleColor }} drop-shadow-sm">
                    {{ $user->name }}
                </span>

                <div class="relative" id="dropdown-container">
                    <button id="dropdown-button" class="px-4 py-2 rounded-md bg-white border shadow-sm hover:shadow-md transition">
                        ☰
                    </button>

                    <div id="dropdown-menu" class="absolute right-0 mt-2 bg-white shadow-xl rounded-lg w-56 overflow-hidden border hidden">
                        {{-- PROFIL --}}
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-gray-100 font-medium">
                            Profil
                        </a>

                        {{-- MENU ADMIN --}}
                        @if($role === 'admin')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Tableau de bord</a>
                            <a href="{{ route('interventions.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Toutes les interventions</a>
                            <a href="{{ route('clients.index') }}" class="block px-4 py-3 hover:bg-gray-100">Gestion des clients</a>
                        @endif

                        {{-- MENU TECHNICIEN --}}
                        @if($role === 'technician')
                            <a href="{{ route('interventions.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Mes interventions</a>
                        @endif

                        {{-- MENU CLIENT --}}
                        @if($role === 'client')
                            <a href="{{ route('client.dashboard') }}" class="block px-4 py-3 hover:bg-gray-100">Mes réparations</a>
                        @endif

                        {{-- DÉCONNEXION --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full text-left px-4 py-3 hover:bg-gray-100 font-medium">Déconnexion</button>
                        </form>
                    </div>
                </div>
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

    // Ouvre le menu au survol
    dropdownContainer.addEventListener('mouseenter', () => {
        clearTimeout(menuTimeout);
        dropdownMenu.classList.remove('hidden');
    });

    // Ferme le menu après un petit délai quand la souris quitte
    dropdownContainer.addEventListener('mouseleave', () => {
        menuTimeout = setTimeout(() => {
            dropdownMenu.classList.add('hidden');
        }, 200); // délai pour pouvoir passer sur le menu
    });

    // Toujours possibilité de cliquer sur le bouton pour toggle
    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });
</script>
