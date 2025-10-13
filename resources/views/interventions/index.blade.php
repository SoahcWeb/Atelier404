<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des interventions - Atelier404</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center">📋 Liste des interventions</h1>

        <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Client</th>
                    <th class="px-4 py-2 text-left">Technicien</th>
                    <th class="px-4 py-2 text-left">Type d’appareil</th>
                    <th class="px-4 py-2 text-left">Priorité</th>
                    <th class="px-4 py-2 text-left">Statut</th>
                    <th class="px-4 py-2 text-left">Date prévue</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($interventions as $intervention)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $intervention->id }}</td>
                        <td class="px-4 py-2">{{ $intervention->client->prenom ?? '—' }} {{ $intervention->client->nom ?? '' }}</td>
                        <td class="px-4 py-2">{{ $intervention->technicien->name ?? 'Non assigné' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($intervention->type_appareil) }}</td>
                        <td class="px-4 py-2">
                            <span class="@if($intervention->priorite == 'haute') text-red-600 font-bold
                                         @elseif($intervention->priorite == 'basse') text-green-600
                                         @else text-yellow-600 @endif">
                                {{ ucfirst($intervention->priorite) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ ucfirst(str_replace('_', ' ', $intervention->statut)) }}</td>
                        <td class="px-4 py-2">{{ $intervention->date_prevue ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Aucune intervention enregistrée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-center mt-8">
            <a href="/" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">🏠 Retour à l’accueil</a>
        </div>
    </div>
</body>
</html>
