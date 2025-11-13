<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Intervention;
use App\Models\Client;

class DashboardController extends Controller
{
    public function dashboard()
    {
         $user = auth()->user();
        if ($user->role->name === 'admin') {
            $interventions = Intervention::with(['client', 'technician'])->get();
            return view('interventions.index', compact('interventions', 'user'));
        }
        elseif ($user->role->name === 'technician') {
            $interventions = Intervention::where('technician_id', $user->id)
            ->with(['client','technician'])
            ->get();
            return view('interventions.index', compact('interventions', 'user'));
        }
        elseif ($user->role->name === 'client') {
            $client = $user->client;
            $interventions = Intervention::where('client_id', $user->id)
            ->with(['technician'])
            ->get();
            return view('client.index', compact('interventions', 'user', 'client'));
        }
        else {
            abort(403, 'Accès non autorisé.');
        }
    }
}
