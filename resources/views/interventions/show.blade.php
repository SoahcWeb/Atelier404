<x-app-layout title="Détail de l'Intervention">
    @php $user = auth()->user(); @endphp

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
     {{-- BOUTONS --}}
            <div class="mt-10 flex flex-wrap gap-4">

                {{-- 🔐 Autorisé pour admin + technicien assigné (SEULE action pour technicien) --}}
                @can('update', $intervention)
                    <a href="{{ route('interventions.edit', $intervention) }}"
                        class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition">
                        Modifier
                    </a>
                @endcan

                {{-- 🔐 Seulement admin : SUPPRIMER --}}
                @can('delete', $intervention)
                    <form action="{{ route('interventions.destroy', $intervention) }}" method="POST"
                        onsubmit="return confirm('Voulez-vous vraiment supprimer cette intervention ?');">
                        @csrf
                        @method('DELETE')

                        <button class="bg-red-600 text-white px-5 py-2.5 rounded-lg hover:bg-red-700 transition">
                            Supprimer
                        </button>
                    </form>
                @endcan

                {{-- 🔐 Seulement admin : REASSIGNER --}}
                @can('reassign', $intervention)
                    <form action="{{ route('interventions.reassign', $intervention) }}" method="POST"
                          class="flex items-center gap-3">
                        @csrf

                        <select name="technician_id" class="border p-2 rounded-lg">
                            @foreach(\App\Models\User::where('role_id', 2)->get() as $technician)
                                <option value="{{ $technician->id }}"
                                    {{ $intervention->technician_id === $technician->id ? 'selected' : '' }}>
                                    {{ $technician->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            Réassigner
                        </button>
                    </form>
                @endcan
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
    <div class="mt-6 mb-3">
        
        @if ($user->role->name === 'admin')
            <a href="{{ route('admin.dashboard') }}"
            class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 transition">
                ← Retour au Tableau
            </a>
        @elseif ($user->role->name === 'technitian')
            <a href="{{ route('interventions.dashboard') }}"
            class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 transition">
                ← Retour au Tableau
            </a>
        @else
            <a href="{{ route('client.dashboard') }}"
            class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700 transition">
                ← Retour au Tableau
            </a>
        @endif
    </div>


</x-app-layout>
