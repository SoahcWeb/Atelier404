<x-app-layout title="Accueil | Demande d'Intervention">

    <div id="presentation" class="bg-white p-8 rounded-lg shadow-xl mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">
            Présentation de l'Atelier 404
        </h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-medium text-indigo-600 mb-3">Votre expert en réparation d'appareils électroniques</h3>
                <p class="text-gray-600 mb-4">
                    Bienvenue à l'Atelier 404. Nous sommes spécialisés dans le diagnostic et la réparation de tous types d'appareils électroniques.
                </p>
                <div>
                    <form action="{{ route('client.show') }}" method="POST" class="space-y-6">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Client Espace Connexion 📲
                        </button>
                    </form>
                     <form action="{{ route('technicien.index') }}" method="POST" class="space-y-6">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Technicien Espace Connexion 🛠  ️
                        </button>
                    </form>
                     <form action="{{ route('administrateur.index') }}" method="POST" class="space-y-6">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Administrateur Espace Connexion  🔐
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-medium text-indigo-600 mb-3">Horaires & Services Proposés</h3>
                <h4 class="font-semibold text-gray-700">🕰️ Horaires d'ouverture :</h4>
                <ul class="text-gray-600 list-disc list-inside ml-4">
                    <li>Lundi - Vendredi: 9h00 - 18h00</li>
                    <li>Samedi: 10h00 - 16h00</li>
                </ul>
                <h4 class="font-semibold text-gray-700 mt-4">🔧 Services Principaux :</h4>
                <ul class="text-gray-600 list-disc list-inside ml-4">
                    <li>Réparation d'écrans</li>
                    <li>Diagnostic de pannes</li>
                    <li>Récupération de données</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="contact" class="bg-white p-8 rounded-lg shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">
            Formulaire de Contact et Demande d'Intervention
        </h2>

        <form action="{{ route('interventions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom et Prénom</label>
                    <input type="text" name="nom" id="nom" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" name="telephone" id="telephone" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="appareil" class="block text-sm font-medium text-gray-700">Type d'Appareil</label>
                    <select id="appareil" name="appareil" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 bg-white focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionnez un type</option>
                        <option value="smartphone">Smartphone</option>
                        <option value="ordinateur">Ordinateur (PC/Mac)</option>
                        <option value="tablette">Tablette</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="description_probleme" class="block text-sm font-medium text-gray-700">Description Détaillée du Problème</label>
                <textarea name="description_probleme" id="description_probleme" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Décrivez en détail la panne, le dommage ou le service souhaité..."></textarea>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Envoyer la Demande et Créer l'Intervention
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
