@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6">FAQ / Aide</h1>

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
            <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }" class="border rounded-md p-4">
                <button
                    @click="open = !open"
                    class="w-full text-left flex justify-between items-center font-semibold text-lg text-gray-800 hover:text-gray-600 cursor-pointer transition-colors duration-200"
                >
                    <span>{{ $faq['question'] }}</span>
                    <span x-text="open ? '-' : '+'"></span>
                </button>
                <div x-show="open" x-transition class="mt-2 text-gray-700">
                    {{ $faq['answer'] }}
                </div>
            </div>
        @endforeach

    </div>
</div>

<!-- Alpine.js pour la gestion des accordéons -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
