<?php

namespace App\Http\Controllers;

use App\Enums\PrioriteEnum;
use App\Enums\StatutEnum;
use App\Models\Intervention;
use App\Models\InterventionImage;
use App\Models\Client;
use App\Http\Requests\StoreInterventionRequest;

class InterventionController extends Controller
{
    // Page d'accueil avec formulaire et affichage images
    public function create()
    {
        return view('home'); // ta page d'accueil avec le formulaire
    }

    // Stockage d'une intervention avec images
    public function store(StoreInterventionRequest $request)
    {
        $validated = $request->validated();

        // Création ou récupération du client
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['nom'],
                'phone' => $validated['telephone'],
            ]
        );

        // Création de l'intervention
        $intervention = $client->interventions()->create([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            'status' => StatutEnum::Nouvelle,
            'priority' => PrioriteEnum::Basse,
        ]);

        // Gestion des images (max 3)
        if ($request->hasFile('images')) {
            $images = array_slice($request->file('images'), 0, 3);
            foreach ($images as $image) {
                $filename = $image->store('interventions', 'public');
                $intervention->images()->create([
                    'filename' => $filename
                ]);
            }
        }

        $message = $client->wasRecentlyCreated
            ? 'Votre compte client a été créé et votre demande est enregistrée. Connectez-vous à votre espace client pour suivre le dossier.'
            : 'Nous avons bien enregistré votre nouvelle demande d\'intervention. Connectez-vous à votre espace client pour suivre le dossier.';

        return redirect()->route('homepage')->with('success', $message);
    }

    // (Optionnel) Liste complète des interventions pour admin
    public function index()
    {
        $interventions = Intervention::with(['client', 'technicien', 'images'])->get();
        return view('interventions.index', compact('interventions'));
    }

    // (Optionnel) Détails d'une intervention
    public function show(Intervention $intervention)
    {
        return view('interventions.show', compact('intervention'));
    }

    // (Optionnel) Edition
    public function edit(Intervention $intervention)
    {
        return view('interventions.edit', compact('intervention'));
    }

    // (Optionnel) Mise à jour
    public function update(StoreInterventionRequest $request, Intervention $intervention)
    {
        $validated = $request->validated();

        $intervention->update([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
        ]);

        return redirect()->route('interventions.show', $intervention)
            ->with('success', 'Intervention mise à jour avec succès.');
    }

    // (Optionnel) Suppression
    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('interventions.index')
            ->with('success', 'Intervention supprimée avec succès.');
    }
}

