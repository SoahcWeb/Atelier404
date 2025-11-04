<x-app-layout>
    <div class="min-h-screen bg-gray-50 p-4 sm:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- En-tête et Bienvenue -->
            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-xl shadow-lg border-t-4 border-indigo-500">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Espace Personnel Client
                    </h1>
                    <p class="text-gray-500 mt-1">Gérez votre profil et vérifiez le statut de vos réparations.</p>
                </div>

                <!-- Bouton de signalement d'un nouveau problème -->
                <a href="#" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-300 transform hover:scale-[1.02]">
                    + Signaler un Nouveau Problème
                </a>
            </header>

            <!-- Contenu Principal : Données du Client et Historique -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Colonne 1 : Détails du Client -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-xl shadow-lg h-full">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            Mes Informations Personnelles
                        </h2>

                        <div class="space-y-4">
                            <!-- Données du Client -->
                            <div class="border-b pb-3">
                                <p class="text-sm font-medium text-gray-500">Nom et Prénom</p>
                                <p class="text-gray-800 font-semibold text-lg">{{ $client->nom }}</p>
                            </div>
                            <div class="border-b pb-3">
                                <p class="text-sm font-medium text-gray-500">Adresse E-mail</p>
                                <p class="text-gray-800 font-semibold text-lg">{{ $client->email }}</p>
                            </div>
                            <div class="border-b pb-3">
                                <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                <p class="text-gray-800 font-semibold text-lg">{{ $client->telephone }}</p>
                            </div>
                            <div class="pb-3">
                                <p class="text-sm font-medium text-gray-500">Type d'Appareil</p>
                                <p class="text-gray-800 font-semibold text-lg">{{ $client->appareil }}</p>
                            </div>
                        </div>

                        <!-- Bouton pour modifier (Si vous implémentez cette fonction) -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                             <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 transition duration-150 font-medium">
                                Modifier mes Informations
                             </a>
                        </div>
                    </div>
                </div>

                <!-- Colonne 2 : Historique des Interventions -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-xl shadow-lg">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                            Historique des Interventions
                        </h2>

                        <!-- SIMULATION DE DONNÉES D'INTERVENTION -->
                        <!--
                            Assumons que vous ayez une variable appelée $interventions
                            qui est une collection des ordres de service du client.
                        -->
                        @php
                            // Mappage des états français aux classes Tailwind pour la couleur
                            $etats = [
                                'Terminée' => ['color' => 'bg-green-100 text-green-700', 'icone' => '✅'],
                                'En Cours' => ['color' => 'bg-yellow-100 text-yellow-700', 'icone' => '🛠️'],
                                'En Attente' => ['color' => 'bg-blue-100 text-blue-700', 'icone' => '⏳'],
                                'Annulée' => ['color' => 'bg-red-100 text-red-700', 'icone' => '❌'],
                            ];

                            $interventions = [
                                (object)['id' => 1001, 'fecha_creacion' => '2025-10-25', 'descripcion' => 'Écran cassé et l\'appareil ne s\'allume pas.','etat' => 'Terminée'],
                                (object)['id' => 1002, 'fecha_creacion' => '2025-11-01', 'descripcion' => 'Problème de batterie, se décharge rapidement.', 'etat' => 'En Cours'],
                                (object)['id' => 1003, 'fecha_creacion' => '2025-11-04', 'descripcion' => 'Le clavier a cessé de répondre.','etat' => 'En Attente'],
                            ];
                        @endphp
                        <!-- FIN DE SIMULATION -->

                        @forelse ($interventions as $intervencion)
                            @php
                                $etat_info = $etats[$intervencion->etat] ?? ['color' => 'bg-gray-100 text-gray-700', 'icone' => '❓'];
                            @endphp
                            <div class="mb-4 p-4 border rounded-lg hover:shadow-md transition duration-200 ease-in-out">
                                <div class="flex justify-between items-center mb-2">
                                    <!-- ID et Date -->
                                    <div class="text-sm font-semibold text-gray-600">
                                        #{{ $intervencion->id }} - Créé le {{ \Carbon\Carbon::parse($intervencion->fecha_creacion)->format('d/m/Y') }}
                                    </div>

                                    <!-- Statut (étiquette dynamique) -->
                                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $etat_info['color'] }}">
                                        {{ $etat_info['icone'] }} {{ $intervencion->etat }}
                                    </span>
                                </div>

                                <p class="text-gray-700 mb-3">
                                    {{ $intervencion->descripcion }}
                                </p>

                                <!-- Bouton de Détail (Simulé) -->
                                <a href="#" class="text-sm text-indigo-500 hover:text-indigo-700 font-medium">
                                    Voir les Détails et l'Avancement
                                </a>
                            </div>
                        @empty
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <p class="text-gray-500">Aucune intervention enregistrée pour le moment. Signalez votre premier problème !</p>
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
