{{-- Ce composant hérite du layout global app.blade.php --}}
<x-app-layout :title="$title">

    {{-- Menu spécifique client --}}
    <div class="bg-white shadow p-4 mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <h2 class="text-xl font-bold">Menu Client</h2>
            <div class="relative inline-block text-left">
                <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                        id="menu-button" aria-expanded="true" aria-haspopup="true">
                    {{ auth()->user()->name }}
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Menu déroulant --}}
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button">
                    <div class="py-1" role="none">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Mon Profil</a>
                        <a href="{{ route('client.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Mes Interventions</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Slot pour le contenu de la page --}}
    {{ $slot }}

</x-app-layout>
