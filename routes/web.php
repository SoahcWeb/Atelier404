<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExportController;

// 🏠 Page d’accueil
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Création d'une intervention
Route::get('/interventions/create', [InterventionController::class, 'create'])->name('interventions.create');
Route::post('/interventions/store', [InterventionController::class, 'store'])->name('interventions.store');
Route::delete('/interventions/images/{image}', [InterventionController::class, 'destroyImage'])
    ->name('interventions.images.destroy')->middleware('auth');

// 🔐 Routes authentifiées
Route::middleware('auth')->group(function () {

    // Espace client
    Route::middleware('role:client')->group(function () {
        Route::get('/espace-client', [ClientController::class, 'espaceClient'])->name('client.dashboard');
    });

    // Espace technicien
    Route::middleware('role:technician')->group(function () {
        Route::get('/espace-tech', [DashboardController::class, 'dashboard'])->name('interventions.dashboard');
    });

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ressources interventions (sauf index et store déjà gérés)
    Route::resource('interventions', InterventionController::class)->except(['index', 'store']);

    // 🔹 Routes admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

        // Toutes les interventions admin
        Route::get('/interventions', [InterventionController::class, 'index'])->name('admin.interventions.index');

        // Gestion des utilisateurs par rôle
        Route::get('/users/{role?}', [UserController::class, 'indexByRole'])
            ->where('role', 'client|technician')
            ->name('admin.users.role');

        // Mise à jour du rôle d’un utilisateur
        Route::post('/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');

        // Export CSV
        Route::get('/export/csv', [ExportController::class, 'exportCsv'])->name('export.csv');
    });
});

// Tableau de bord général
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes
require __DIR__.'/auth.php';
