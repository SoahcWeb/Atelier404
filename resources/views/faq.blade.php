<x-app-layout title="FAQ | Atelier 404">

    <div class="min-h-screen px-4 py-10" style="background-color:#f9eddd; color:#442b1f;">
        <div class="mx-auto max-w-7xl">
            <h1 class="mb-6 text-3xl font-bold">FAQ / Aide</h1>

            <div class="space-y-4">

                @php
                    $faqs = [
                        [
                            'question' => 'Comment prendre rendez-vous pour une réparation ?',
                            'answer' => 'Vous pouvez utiliser le formulaire de contact sur la page d’accueil. Une fois le formulaire soumis correctement, un compte client et une intervention seront créés automatiquement.'
                        ],
                        [
                            'question' => 'Quels types d’appareils peuvent être réparés ?',
                            'answer' => 'Nous acceptons la plupart des équipements informatiques tels que ordinateurs portables, PC de bureau, tablettes, imprimantes et périphériques associés.'
                        ],
                        [
                            'question' => 'Y a-t-il des coûts pour les réparations ?',
                            'answer' => 'Non, toutes les interventions sont gratuites, dans le cadre du projet étudiant Atelier 404.'
                        ],
                        [
                            'question' => 'Comment suivre l’avancement de ma réparation ?',
                            'answer' => 'Après la création de l’intervention, vous recevrez un suivi par email et pouvez consulter l’état de votre demande via l’espace client.'
                        ],
                        [
                            'question' => 'Puis-je soumettre plusieurs appareils en même temps ?',
                            'answer' => 'Oui, vous pouvez soumettre plusieurs interventions séparées. Chaque appareil sera enregistré comme une intervention distincte pour assurer un suivi précis.'
                        ],
                        [
                            'question' => 'Qui s’occupe des réparations ?',
                            'answer' => 'Les interventions sont réalisées par nos étudiants techniciens, supervisés par les administrateurs du projet pour garantir qualité et sécurité.'
                        ],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }" class="p-4 border rounded-md" style="border-color:#442b1f;">
                        <button
                            @click="open = !open"
                            class="flex items-center justify-between w-full text-lg font-semibold text-left transition-colors duration-200 cursor-pointer hover:text-gray-600"
                            style="color:#442b1f;"
                        >
                            <span>{{ $faq['question'] }}</span>
                            <span x-text="open ? '-' : '+'"></span>
                        </button>
                        <div x-show="open" x-transition class="mt-2" style="color:#442b1f;">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Alpine.js pour accordéon -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</x-app-layout>
