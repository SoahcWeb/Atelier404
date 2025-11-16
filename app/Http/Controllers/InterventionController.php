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
use App\Models\Role;
use App\Http\Requests\UpdateInterventionRequest;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    /**
     * Affiche la liste des interventions.
     */
    public function index()
    {

         $user = auth()->user();

        if ($user->role->name === 'admin') {
            $interventions = Intervention::with(['client', 'technician'])->get();
        }
        elseif ($user->role->name === 'technician') {
            $interventions = Intervention::where('technician_id', $user->id)
                ->with(['client', 'technician'])
                ->get();

        }
        else {
            abort(403, 'Accès non autorisé.');
        }


        return view('interventions.index', compact('interventions', 'user'));
    }

    public function show(Intervention $intervention)
    {
        $this->authorize('view', $intervention);

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
                'name' => $validated['nom'],
                'password' => Hash::make(Str::random(12)),
                'role_id' => Role::where('name', 'client')->first()->id,
            ]
        );

        $client = Client::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validated['telephone'],
                'address' => $validated['address'] ?? null,
            ]
        );

        $intervention = Intervention::create([
            'client_id' => $user->id,
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            'status' => StatutEnum::Nouvelle,
            'priority' => PrioriteEnum::Basse,
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
         $this->authorize('update', $intervention);

        return view('interventions.edit', compact('intervention'));
    }

    public function update(UpdateInterventionRequest $request, Intervention $intervention)
    {
        $this->authorize('update', $intervention);

        $validated = $request->validated();

        $intervention->update($validated);

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Intervention mise à jour avec succès.');
    }

    public function destroy(Intervention $intervention)
    {
        $this->authorize('delete', $intervention);

        $intervention->delete();

        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée avec succès.');
    }

    public function reassign(Request $request, Intervention $intervention)
    {
        $this->authorize('reassign', $intervention);

        $validated = $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $intervention->update([
            'technician_id' => $validated['technician_id'],
        ]);

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Technicien réassigné avec succès.');
    }


}


