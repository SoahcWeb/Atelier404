<x-app-layout title="Détail de l'Intervention">

    <h1 class="text-2xl font-bold text-indigo-700 mb-6">
        Intervention : {{ $intervention->device_type }}
    </h1>

    <!-- Informations client -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Informations Client</h2>
        <ul class="text-gray-600">
            <li><strong>Nom :</strong> {{ $intervention->client->name ?? 'Client inconnu' }}</li>
            <li><strong>Email :</strong> {{ $intervention->client->email ?? 'Non renseigné' }}</li>
            <li><strong>Téléphone :</strong> {{ $intervention->client->phone ?? 'Non renseigné' }}</li>
            <li><strong>Adresse :</strong> {{ $intervention->client->address ?? 'Non renseignée' }}</li>
        </ul>
    </div>

    <!-- Informations intervention -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Détails de l'Intervention</h2>
        <ul class="text-gray-600">
            <li><strong>Type d'appareil :</strong> {{ $intervention->device_type }}</li>
            <li><strong>Description :</strong> {{ $intervention->description }}</li>
            <li><strong>Statut :</strong> {{ ucfirst($intervention->status->value ?? $intervention->status) }}</li>
            <li><strong>Priorité :</strong> {{ $intervention->priority }}</li>
            <li><strong>Technicien :</strong> {{ $intervention->technician->name ?? 'Non assigné' }}</li>
            <li><strong>Date :</strong> {{ $intervention->created_at->format('d/m/Y') }}</li>
        </ul>
    </div>

    <!-- Images -->
    @if($intervention->images->isNotEmpty())
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Images</h2>

            <div class="flex flex-wrap">
                @foreach($intervention->images as $img)
                    <div class="relative m-2">
                        <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                            <img src="{{ asset('storage/' . ($img->thumbnail_path ?? $img->path)) }}"
                                 alt="Image intervention" class="w-32 h-auto rounded border">
                        </a>

                        <!-- Suppression : seulement admin + technicien -->
                        @if(in_array($user->role->name, ['admin', 'technician']))
                            <form action="{{ route('interventions.images.destroy', $img->id) }}"
                                  method="POST"
                                  class="absolute top-0 right-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cette image ?');"
                                        class="bg-red-600 text-white rounded-full w-5 h-5 text-center leading-5 hover:bg-red-700">
                                    ×
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Bouton retour dynamique -->
    <a href="{{ route('interventions.dashboard') }}"
       class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 transition">
        ← Retour au Tableau
    </a>

</x-app-layout>
