<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Intervention;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Afficher l'espace client pour l'utilisateur connecté
     */
    public function espaceClient()
    {
        $user = Auth::user(); // utilisateur connecté

        $client = Client::where('user_id', $user->id)->first();

        $interventions = $client
            ? Intervention::where('client_id', $client->id)->get()
            : collect();

        return view('client.index', compact('user', 'client', 'interventions'));
    }
}
