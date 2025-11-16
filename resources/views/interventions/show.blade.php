<x-app-layout title="Détails de l’intervention">

    <div class="max-w-3xl mx-auto mt-10">

        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">
            Intervention #{{ $intervention->id }}
        </h1>

        <div class="bg-white shadow-lg p-8 rounded-xl border">

            {{-- Informations client --}}
            <h2 class="text-xl font-semibold text-gray-800 mb-3 border-b pb-2">Client</h2>

            <div class="space-y-1 text-gray-700">
                <p><strong>Nom :</strong> {{ $intervention->client->name }}</p>
                <p><strong>Téléphone :</strong> {{ $intervention->client->phone }}</p>
                <p><strong>Adresse :</strong> {{ $intervention->client->address }}</p>
            </div>

            <hr class="my-6">

            {{-- Informations Intervention --}}
            <h2 class="text-xl font-semibold text-gray-800 mb-3 border-b pb-2">Intervention</h2>

            <div class="space-y-1 text-gray-700">
                <p><strong>Type d’appareil :</strong> {{ $intervention->device_type }}</p>
                <p><strong>Description :</strong> {{ $intervention->description }}</p>
                <p><strong>Statut :</strong> {{ $intervention->status }}</p>
                <p><strong>Priorité :</strong> {{ $intervention->priority }}</p>
            </div>

            <hr class="my-6">

            {{-- Technicien --}}
            <h2 class="text-xl font-semibold text-gray-800 mb-3 border-b pb-2">Technicien</h2>

            <p class="text-gray-700">
                <strong>Assigné :</strong>
                {{ $intervention->technician->name ?? 'Non assigné' }}
            </p>


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

            {{-- Retour --}}
            <div class="mt-8 text-center">
                <a href="{{ route('interventions.index') }}"
                   class="text-gray-600 hover:text-gray-800 underline">
                    ← Retour
                </a>
            </div>

        </div>
    </div>

</x-app-layout>
