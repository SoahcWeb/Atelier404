<x-app-layout title="Espace Technique">

    <h1 class="text-2xl font-bold text-indigo-700 mb-6">
        @if($user->role->name === 'admin')
            Tableau de Bord Administrateur
        @else
            Mes Interventions — {{ $user->name }}
        @endif
    </h1>



    <table class="w-full border text-sm text-gray-700">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Client</th>
                <th class="p-2 text-left">Type d'appareil</th>
                <th class="p-2 text-left">Statut</th>

                @if ($user->role->name === 'admin')
                    <th class="p-2 text-left">Technicien</th>
                @endif

                <th class="p-2 text-left">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($interventions as $intervention)
                <tr class="border-t">
                    <td class="p-2">
                        {{ $intervention->client->user->name ?? 'Client inconnu' }}
                    </td>
                    <td class="p-2">{{ $intervention->device_type }}</td>

                    <td class="p-2">
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded">
                            {{ ucfirst($intervention->status->value ?? $intervention->status) }}
                        </span>
                    </td>

                    @if ($user->role->name === 'admin')
                        <td class="p-2">
                            {{ $intervention->technician->name ?? 'Non assigné' }}
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
