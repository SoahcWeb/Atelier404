<x-app-layout title="Espace Client">

    <div class="container mx-auto p-4">

        <h1 class="text-2xl font-bold mb-4">Bienvenue, {{ $user->name }}</h1>
        <ul class="mb-4">
            <li><strong>Email :</strong> {{ $user->email }}</li>
            <li><strong>Rôle :</strong> {{ optional($user->role)?->name ?? 'Aucun' }}</li>
        </ul>

        <h2 class="text-xl font-semibold mb-2">Mes interventions</h2>

        @if($interventions->isEmpty())
            <p>Aucune intervention pour le moment.</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Titre</th>
                        <th class="border px-4 py-2">Statut</th>
                        <th class="border px-4 py-2">Créé le</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($interventions as $intervention)
                        <tr>
                            <td class="border px-4 py-2">{{ $intervention->id }}</td>
                            <td class="border px-4 py-2">{{ $intervention->titre }}</td>
                            <td class="border px-4 py-2">{{ $intervention->status }}</td>
                            <td class="border px-4 py-2">{{ $intervention->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

</x-app-layout>
