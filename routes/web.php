<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ClientController;

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

Route::post('/interventions/store', [InterventionController::class, 'store'])->name('interventions.store');

Route::middleware('auth')->group(function () {
    // Espace client
    Route::get('/espace-client', [ClientController::class, 'dashboard'])->name('client.dashboard');

    // Espace technicien / admin
    Route::get('/espace-tech', [InterventionController::class, 'dashboard'])->name('interventions.dashboard');
});

// 🧭 Tableau de bord (nécessite authentification et vérification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Gestion du profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clients', ClientController::class);

    Route::resource('interventions', InterventionController::class)->except(['index', 'store']);
});

// 🔐 Auth routes (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
