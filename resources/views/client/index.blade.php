<x-app-layout title="Espace Client">

    {{-- Conteneur global harmonisé avec la home --}}
    <div class="bg-[#f9eddd] text-[#442b1f] py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Bienvenue --}}
            <h1 class="mb-8 text-3xl font-bold">
                Bienvenue, {{ $user->name }}
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Bloc Informations personnelles --}}
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-2xl font-semibold text-[#442b1f]">Vos Informations Personnelles</h2>
                    <ul class="space-y-2 text-[#442b1f]">
                        <li><strong>Email :</strong> {{ $user->email }}</li>
                        <li><strong>Téléphone :</strong> {{ $client->phone ?? 'Non renseigné' }}</li>
                        <li><strong>Adresse :</strong> {{ $client->address ?? 'Non renseignée' }}</li>
                    </ul>
                </div>

                {{-- Bloc Demandes d'interventions --}}
                <div class="p-6 bg-white rounded-lg shadow-md overflow-x-auto">
                    <div class="flex items-start justify-between mb-4 gap-4">
                        <h2 class="text-2xl font-semibold text-[#442b1f]">
                            Vos demandes d’interventions
                        </h2>

                        {{-- Bouton placé en haut à droite du bloc --}}
                        <a href="{{ route('interventions.create') }}"
                           class="px-4 py-2 bg-[#442b1f] text-[#d0ba9b] font-semibold rounded hover:opacity-90 transition whitespace-nowrap">
                            Nouvelle demande
                        </a>
                    </div>

                    @if($interventions->isEmpty())
                        <p>Aucune intervention enregistrée pour le moment.</p>
                    @else
                        <table class="w-full text-sm text-[#442b1f] bg-[#f9eddd] border border-[#d0ba9b] rounded-lg overflow-hidden">
                            <thead class="bg-[#d0ba9b] text-[#442b1f]">
                                <tr>
                                    <th class="p-3 text-left font-semibold">Type d'appareil</th>
                                    <th class="p-3 text-left font-semibold">Statut</th>
                                    <th class="p-3 text-left font-semibold">Images</th>
                                    <th class="p-3 text-left font-semibold">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($interventions as $intervention)
                                    <tr class="border-t border-[#d0ba9b] hover:bg-[#e8d7c3] transition">
                                        <td class="p-3 font-medium">{{ $intervention->device_type }}</td>
                                        <td class="p-3">{{ $intervention->status->value ?? $intervention->status }}</td>
                                        <td class="p-3 flex flex-wrap gap-2">
                                            @foreach($intervention->images as $image)
                                                <a href="{{ asset('storage/'.$image->path) }}" target="_blank">
                                                    <img src="{{ asset('storage/'.$image->thumbnail_path ?? $image->path) }}"
                                                         class="w-20 h-20 object-cover border rounded">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('interventions.show', $intervention->id) }}"
                                               class="px-3 py-1 bg-[#442b1f] text-[#d0ba9b] font-semibold rounded hover:opacity-90 transition">
                                                Voir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
