<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes web de l'application.
|
*/

// 🏠 Page d’accueil
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// Page FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

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

    // 🔹 Espace client (client connecté)
    Route::middleware('role:client')->group(function () {
        Route::get('/espace-client', [ClientController::class, 'espaceClient'])
            ->name('client.dashboard');
    });

    // 🔹 Espace technicien (technician)
    Route::middleware('role:technician')->group(function () {
        Route::get('/espace-tech', [DashboardController::class, 'dashboard'])
            ->name('interventions.dashboard');
    });

   // Affichage du profil utilisateur
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Ressources clients (CRUD complet)
    Route::resource('clients', ClientController::class);

    // Ressources interventions (sauf index et store déjà gérés)
    Route::resource('interventions', InterventionController::class)->except(['index', 'store']);

    // 🔹 Route index des interventions (Admin uniquement)
    Route::get('/admin/interventions', [InterventionController::class, 'index'])
        ->name('interventions.index')
        ->middleware('role:admin');
});

// Tableau de bord général (par défaut)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔐 Auth routes (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
