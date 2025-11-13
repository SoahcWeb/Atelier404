<?php

namespace App\Http\Controllers;

use App\Enums\PrioriteEnum;
use App\Enums\StatutEnum;
use App\Models\Intervention;
use App\Http\Requests\StoreInterventionRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        // 2. Gestion du client (création ou récupération)
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                // Les attributs de création (utilisés SEULEMENT si le client est nouveau)
                'name' => $validated['nom'],
                'password' => Hash::make(Str::random(12)), // Mot de passe par défaut à changer
                'phone' => $validated['telephone'],
            ]
        );

        $client = Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validated['telephone'],
                'adresse' => $validated['address'] ?? null,// Valeur par défaut
            ]
        );

        $intervention = $client->interventions()->create([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            'status' => StatutEnum::Nouvelle,
            'priority' => PrioriteEnum::Basse,
            // ... autres champs
        ]);

        // 5. Redirection et Instructions

        $message = '';
        if ($client->wasRecentlyCreated) {
            $message = 'Votre compte client a été créé et votre demande est enregistrée. Connectez-vous à votre espace client pour suivre le dossier.';
        } else {
            $message = 'Nous avons bien enregistré votre nouvelle demande d\'intervention. Connectez-vous à votre espace client pour suivre le dossier.';
        }


        return redirect()->route('homepage')->with('success', $message);
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


