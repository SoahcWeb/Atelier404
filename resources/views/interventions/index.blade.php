<x-app-layout title="Espace Technique">

    <h1 class="text-2xl font-bold text-indigo-700 mb-6">
        @if($user->role->name === 'admin')
            Tableau de Bord Administrateur
        @elseif($user->role->name === 'technician')
            Mes Interventions — {{ $user->name }}
        @else
            Mes Interventions Client — {{ $user->name }}
        @endif
    </h1>


    {{-- Informations personnelles visibles uniquement pour les clients --}}
    @if($user->role->name === 'client' && isset($client))
    <div class="bg-white border rounded-lg p-4 mb-6 shadow-sm">
        <h2 class="font-semibold text-gray-800 mb-2">Vos informations</h2>
        <ul class="text-gray-600 text-sm">
            <li><strong>Email :</strong> {{ $user->email }}</li>
            <li><strong>Téléphone :</strong> {{ $client->phone ?? 'Non renseigné' }}</li>
            <li><strong>Adresse :</strong> {{ $client->address ?? 'Non renseignée' }}</li>
        </ul>
    </div>
    @endif



    <table class="w-full border text-sm text-gray-700">
        <thead class="bg-gray-100">
            <tr>
                @if($user->role->name !== 'client')
                    <th class="p-2 text-left">Client</th>
                @endif

                <th class="p-2 text-left">Type d'appareil</th>
                <th class="p-2 text-left">Statut</th>
                <th class="p-2 text-left">Images</th>

                @if ($user->role->name === 'admin')
                    <th class="p-2 text-left">Technicien</th>
                @endif

                <th class="p-2 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($interventions as $intervention)
                <tr class="border-t">

                    {{-- Colonne CLIENT sauf si l'utilisateur est un client --}}
                    @if($user->role->name !== 'client')
                        <td class="p-2">
                            {{ $intervention->client->user->name ?? 'Client inconnu' }}
                        </td>
                    @endif

                    <td class="p-2">{{ $intervention->device_type }}</td>

                    <td class="p-2">
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded">
                            {{ ucfirst($intervention->status->value ?? $intervention->status) }}
                        </span>
                    </td>

                    <td class="p-2 flex flex-wrap">
                        @foreach($intervention->images->take(3) as $img)
                            <div class="relative m-2">
                                <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . ($img->thumbnail_path ?? $img->path)) }}"
                                         alt="Image intervention"
                                         class="w-24 h-auto rounded border">
                                </a>

                                @if($user->role->name === 'admin' || $user->role->name === 'technician')
                                <form action="{{ route('interventions.images.destroy', $img->id) }}"
                                      method="POST"
                                      class="absolute top-0 right-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Supprimer cette image ?');"
                                            class="bg-red-600 text-white rounded-full w-5 h-5 text-center leading-5 hover:bg-red-700">
                                        ×
                                    </button>
                                </form>
                                @endif
                            </div>
                        @endforeach
                    </td>

                    @if ($user->role->name === 'admin')
                        <td class="p-2">
                            {{ $intervention->technician->user->name ?? 'Non assigné' }}
                        </td>
                    @endif

                    <td class="p-2">
                        <a href="{{ route('interventions.show', $intervention) }}"
                           class="text-indigo-600 hover:underline">Voir</a>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
