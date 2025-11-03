<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Http\Requests\StoreInterventionRequest;
use App\Models\Client;

class InterventionController extends Controller
{
    /**
     * Affiche la liste des interventions.
     */
    public function index()
    {
        // On récupère toutes les interventions avec le client et le technicien
        $interventions = Intervention::with(['client', 'technicien'])->get();

        // On envoie la variable à la vue
        return view('interventions.index', compact('interventions'));
    }

    public function show(Intervention $intervention)
    {
        return view('interventions.show', compact('intervention'));
    }

    public function create()
    {
        return view('interventions.create');
    }

    public function store(StoreInterventionRequest $request)
    {
        // 1. Récupération des données validées
        $validated = $request->validated();

        // 2. LOGIQUE DU CLIENT : Création si nouveau, Récupération si existant (SANS MODIFICATION)

        // Les critères de recherche sont l'email (unique pour identifier le client).
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            [
                // Les attributs de création (utilisés SEULEMENT si le client est nouveau)
                'name' => $validated['name'],
                'phone' => $validated['phone'],
            ]
        );

        // 3. Préparation des données pour l'Intervention
        // Nettoyage de l'array validé pour ne garder que les champs de l'Intervention.
        $interventionData = array_diff_key($validated, array_flip(['nom', 'email', 'telephone']));

        // 4. Création de l'Intervention et Association au Client

        $intervention = $client->interventions()->create([
            'type_appareil' => $interventionData['appareil'],
            'description' => $interventionData['description_probleme'],
            'status' => 'pending', // Statut initial
            // ... autres champs
        ]);

        // 5. Redirection et Instructions

        $message = '';
        if ($client->wasRecentlyCreated) {
            $message = 'Votre compte client a été créé et votre demande est enregistrée. Veuillez vérifier votre email pour finaliser l\'accès à votre espace client et suivre l\'intervention.';
        } else {
            $message = 'Nous avons bien enregistré votre nouvelle demande d\'intervention. Connectez-vous à votre espace client pour suivre le dossier.';
        }


        return redirect()->route('client.index')->with('success', $message);
    }

    public function edit(Intervention $intervention)
    {
        return view('interventions.edit', compact('intervention'));
    }

    public function update(StoreInterventionRequest $request, Intervention $intervention)
    {
        $validated = $request->validated();

        $intervention->update([
            'type_appareil' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            // ... autres champs
        ]);

        return redirect()->route('interventions.show', $intervention)->with('success', 'Intervention mise à jour avec succès.');
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();

        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée avec succès.');
    }
}


