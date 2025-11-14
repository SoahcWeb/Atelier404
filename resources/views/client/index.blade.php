<x-app-layout title="Espace Client">

    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Bienvenue, {{ $user->name }}</h1>

    {{-- Infos personnelles --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Vos Informations Personnelles</h2>
        <ul class="text-gray-600">
            <li><strong>Email :</strong> {{ $user->email }}</li>
            <li><strong>Téléphone :</strong> {{ $client->phone }}</li>
            <li><strong>Adresse :</strong> {{ $client->address ?? 'Non renseignée' }}</li>
        </ul>
    </div>

    {{-- Interventions --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Vos Interventions</h2>

        @if($interventions->isEmpty())
            <p class="text-gray-500">Aucune intervention enregistrée pour le moment.</p>
        @else
            <table class="w-full border text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Type d'appareil</th>
                        <th class="p-2 text-left">Description</th>
                        <th class="p-2 text-left">Statut</th>
                        <th class="p-2 text-left">Date</th>
                        <th class="p-2 text-left">Images</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($interventions as $intervention)
                        <tr class="border-t">
                            <td class="p-2">{{ $intervention->device_type }}</td>
                            <td class="p-2">{{ Str::limit($intervention->description, 50) }}</td>
                            <td class="p-2 font-medium">{{ $intervention->status }}</td>
                            <td class="p-2">{{ $intervention->created_at->format('d/m/Y') }}</td>
                            <td class="p-2">
                                @foreach($intervention->images as $image)
                                    <div class="inline-block relative mr-2 mb-2">
                                        <a href="{{ asset('storage/'.$image->path) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$image->thumbnail_path ?? $image->path) }}"
                                                 width="80" class="rounded border">
                                        </a>

                                        {{-- Bouton suppression --}}
                                        <form action="{{ route('interventions.images.destroy', $image->id) }}"
                                              method="POST" class="absolute top-0 right-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white rounded-full w-5 h-5 text-xs hover:bg-red-700"
                                                    title="Supprimer">×</button>
                                        </form>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Bouton nouvelle intervention --}}
    <a href="{{ route('homepage') }}"
       class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 transition">
        ➕ Nouvelle Demande d’Intervention
    </a>

</x-app-layout>
