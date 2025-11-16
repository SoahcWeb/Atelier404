<x-app-layout title="Mon Profil">
    <h1 class="text-3xl font-bold mb-6">Mon Profil</h1>

    <div class="bg-white p-6 rounded-lg shadow-md space-y-2 text-[#442b1f]">
        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Téléphone :</strong> {{ $user->phone ?? 'Non renseigné' }}</p>
        <p><strong>Adresse :</strong> {{ $user->address ?? 'Non renseignée' }}</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('profile.edit') }}"
           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
            Modifier mon profil
        </a>
    </div>
</x-app-layout>
