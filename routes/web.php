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

Route::post('/interventions/store', [InterventionController::class, 'store'])->name('interventions.store');

Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Espace client
    Route::get('/espace-client', [ClientController::class, 'index'])->name('client.index');

    // Espace technicien / admin
    Route::get('/espace-tech', [InterventionController::class, 'index'])->name('interventions.index');

    Route::resource('clients', ClientController::class);

    Route::resource('interventions', InterventionController::class)->except(['store']);

    Route::post('/interventions/{intervention}/reassign', [InterventionController::class, 'reassign'])->name('interventions.reassign');
});

require __DIR__.'/auth.php';
