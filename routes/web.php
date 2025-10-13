<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici se trouvent toutes les routes web de l'application.
| Ces routes sont chargées par le RouteServiceProvider.
|
*/

// 🏠 Page d’accueil → redirige vers la liste des interventions
Route::get('/', function () {
    return redirect()->route('interventions.index');
});

// 📋 Liste des interventions
Route::get('/interventions', [InterventionController::class, 'index'])
    ->name('interventions.index');

// 🧭 Tableau de bord (nécessite authentification et vérification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Gestion du profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔐 Auth routes (login, register, forgot password, etc.)
require __DIR__.'/auth.php';
