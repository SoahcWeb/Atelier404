<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Afficher l'espace client pour l'utilisateur connecté.
     */
    public function espaceClient()
    {
        $user = Auth::user(); // Récupère l'utilisateur connecté
        $client = Client::where('user_id', $user->id)->first(); // Récupère le client associé
        $interventions = $client ? $client->interventions : collect(); // Ses interventions ou collection vide

        return view('client.index', compact('user', 'client', 'interventions'));
    }

    /**
     * Afficher la liste de tous les clients (admin uniquement si besoin).
     */
    public function index()
    {
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    /**
     * Formulaire de création d'un nouveau client.
     */
    public function create()
    {
        // Si nécessaire
    }

    /**
     * Stocker un nouveau client.
     */
    public function store(Request $request)
    {
        // Si nécessaire
    }

    /**
     * Afficher un client spécifique.
     */
    public function show(Client $client)
    {
        // Si nécessaire
    }

    /**
     * Formulaire d'édition d'un client.
     */
    public function edit(Client $client)
    {
        // Si nécessaire
    }

    /**
     * Mettre à jour un client.
     */
    public function update(Request $request, Client $client)
    {
        // Si nécessaire
    }

    /**
     * Supprimer un client.
     */
    public function destroy(Client $client)
    {
        // Si nécessaire
    }
}
