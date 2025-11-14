<?php

namespace App\Http\Controllers;

use App\Enums\PrioriteEnum;
use App\Enums\StatutEnum;
use App\Models\Intervention;
use App\Http\Requests\StoreInterventionRequest;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InterventionController extends Controller
{
    /**
     * Affiche la liste des interventions.
     */
    public function index()
    {
        $interventions = Intervention::with(['client', 'technician'])->get();
        return view('interventions.index', compact('interventions'));
    }

    /**
     * Affiche une intervention spécifique.
     */
    public function show(Intervention $intervention)
    {
        $intervention->load(['client', 'technician']);
        return view('interventions.show', compact('intervention'));
    }

    /**
     * Formulaire de création d'une intervention.
     */
    public function create()
    {
        return view('interventions.create');
    }

    /**
     * Enregistre une nouvelle intervention.
     */
    public function store(StoreInterventionRequest $request)
    {
        $validated = $request->validated();

        // 1️⃣ Vérifier ou créer le rôle "client" (tout en minuscule pour SQLite CHECK constraint)
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // 2️⃣ Nom et email du client avec fallback
        $nomClient = trim($validated['nom'] ?? '') ?: 'Client sans nom';
        $emailClient = $validated['email'];

        // 3️⃣ Créer ou récupérer l'utilisateur Client
        $user = User::firstOrCreate(
            ['email' => $emailClient],
            [
                'name' => $nomClient,
                'password' => Hash::make(Str::random(12)),
                'role_id' => $clientRole->id,
            ]
        );

        // 4️⃣ Créer ou mettre à jour le client lié à cet utilisateur
        $client = Client::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name'    => $nomClient,
                'email'   => $emailClient,
                'phone'   => $validated['telephone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]
        );

        // 5️⃣ Créer l'intervention
        $intervention = $client->interventions()->create([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            'status' => StatutEnum::Nouvelle,
            'priority' => PrioriteEnum::Basse,
        ]);

        // 6️⃣ Message flash selon si client créé ou existant
        $message = $client->wasRecentlyCreated
            ? 'Votre compte client a été créé et votre demande est enregistrée. Connectez-vous à votre espace client pour suivre le dossier.'
            : 'Nous avons bien enregistré votre nouvelle demande d\'intervention. Connectez-vous à votre espace client pour suivre le dossier.';

        return redirect()->route('homepage')->with('success', $message);
    }

    /**
     * Formulaire d'édition d'une intervention.
     */
    public function edit(Intervention $intervention)
    {
        return view('interventions.edit', compact('intervention'));
    }

    /**
     * Met à jour une intervention.
     */
    public function update(StoreInterventionRequest $request, Intervention $intervention)
    {
        $validated = $request->validated();

        $intervention->update([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            // Autres champs si nécessaire
        ]);

        return redirect()->route('interventions.show', $intervention)
            ->with('success', 'Intervention mise à jour avec succès.');
    }

    /**
     * Supprime une intervention.
     */
    public function destroy(Intervention $intervention)
    {
        $intervention->delete();

        return redirect()->route('interventions.index')
            ->with('success', 'Intervention supprimée avec succès.');
    }
}
