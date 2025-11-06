<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

       return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }

    public function dashboard()
    {
        // $user = auth()->user();
        // $client = $user->client;
        // $interventions = $user->client->interventions;

        // return view('client.index', compact('interventions'));

            // ⚠️ Uniquement pour les tests — à déplacer plus tard dans une route protégée ⚠️
        $client = \App\Models\Client::first();
        $interventions = $client->interventions;

        if (!$client) {
            return redirect()->route('homepage')->with('error', 'Aucun client trouvé dans la base de données.');
        }

        return view('client.index', compact('client','interventions'));

    }
}
