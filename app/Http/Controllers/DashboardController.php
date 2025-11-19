<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        if ($user->role->name === 'admin') {
            // Tous les interventions pour l'admin
            $interventions = Intervention::with(['client.user', 'technician', 'images'])
                ->latest()
                ->get();

            return view('interventions.index', compact('interventions', 'user'));
        }

        elseif ($user->role->name === 'technician') {
            // Interventions assignées au technicien connecté
            $interventions = $user->interventionsAsTechnician()
                ->with(['client.user', 'technician', 'images'])
                ->latest()
                ->get();

            return view('interventions.index', compact('interventions', 'user'));
        }

        elseif ($user->role->name === 'client') {
            // Interventions liées au client via la relation
            $client = $user->client;

            if (!$client) {
                abort(404, 'Client non trouvé.');
            }

            $interventions = $client->interventions()
                ->with(['technician', 'images'])
                ->latest()
                ->get();

            // Utiliser la même vue que les admins/techniciens
            return view('interventions.index', compact('interventions', 'user', 'client'));
        }

        else {
            abort(403, 'Accès non autorisé.');
        }
    }
}

