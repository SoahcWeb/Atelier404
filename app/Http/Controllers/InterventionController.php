<?php

namespace App\Http\Controllers;

use App\Models\Intervention;

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
}


