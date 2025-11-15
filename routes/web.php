<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes web de l'application.
| Ces routes sont chargées par le RouteServiceProvider.
|
*/

// 🏠 Page d’accueil
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// Formulaire de création d'une intervention (GET)
Route::get('/interventions/create', [InterventionController::class, 'create'])
    ->name('interventions.create');

// Création d'une intervention (POST)
Route::post('/interventions/store', [InterventionController::class, 'store'])
    ->name('interventions.store');

// Route pour supprimer une image d'une intervention
Route::delete('/interventions/images/{image}', [InterventionController::class, 'destroyImage'])
    ->name('interventions.images.destroy')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    // Espace client
    Route::get('/espace-client', [DashboardController::class, 'dashboard'])
        ->name('client.dashboard');

    // Espace technicien / admin
    Route::get('/espace-tech', [DashboardController::class, 'dashboard'])
        ->name('interventions.dashboard');

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ressources clients
    Route::resource('clients', ClientController::class);

    // Ressources interventions (sauf index et store déjà gérés)
    Route::resource('interventions', InterventionController::class)->except(['index', 'store']);
});

// Tableau de bord par défaut
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔐 Auth routes (login, register, forgot password, etc.)
require __DIR__.'/auth.php';

