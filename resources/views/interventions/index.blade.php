<x-app-layout title="Espace Technique">

    <h1 class="text-2xl font-bold text-indigo-700 mb-6">
        @if($user->role->name === 'admin')
            Tableau de Bord Administrateur
        @else
            Mes Interventions {{ $user->name }}
        @endif
    </h1>

    <table class="w-full border text-sm text-gray-700">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Client</th>
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
                    <td class="p-2">{{ $intervention->client->name ?? 'Client inconnu' }}</td>
                    <td class="p-2">{{ $intervention->device_type }}</td>
                    <td class="p-2">{{ $intervention->status }}</td>
                    <td class="p-2 flex flex-wrap">
                        @foreach($intervention->images->take(3) as $img)
                            <div class="relative m-2">
                                <a href="{{ asset('storage/' . $img->path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . ($img->thumbnail_path ?? $img->path)) }}"
                                         alt="Image intervention" class="w-24 h-auto rounded border">
                                </a>
                                <form action="{{ route('interventions.images.destroy', $img->id) }}" method="POST"
                                      class="absolute top-0 right-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette image ?');"
                                            class="bg-red-600 text-white rounded-full w-5 h-5 text-center leading-5 hover:bg-red-700">
                                        ×
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </td>
                    @if ($user->role->name === 'admin')
                        <td class="p-2">{{ $intervention->technician->name ?? 'Non assigné' }}</td>
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
