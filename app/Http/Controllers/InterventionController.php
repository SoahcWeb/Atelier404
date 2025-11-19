<?php

namespace App\Http\Controllers;

use App\Enums\PrioriteEnum;
use App\Enums\StatutEnum;
use App\Models\Intervention;
use App\Http\Requests\StoreInterventionRequest;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateInterventionRequest;

class InterventionController extends Controller
{
    public function index()
    {
        $interventions = Intervention::with(['client', 'technician', 'images'])->get();
        return view('interventions.index', compact('interventions'));
    }

    public function show(Intervention $intervention)
    {
        $intervention->load(['client', 'technician', 'images']);
        return view('interventions.show', compact('intervention'));
    }

    public function create()
    {
        return view('interventions.create');
    }

    public function store(StoreInterventionRequest $request)
    {
        $validated = $request->validated();

        // Vérifie ou crée le rôle "client"
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Nom et email du client avec fallback
        $nomClient = trim($validated['nom'] ?? '') ?: 'Client sans nom';
        $emailClient = $validated['email'];

        // Crée ou récupère l'utilisateur Client
        $user = User::firstOrCreate(
            ['email' => $emailClient],
            [
                'name' => $nomClient,
                'password' => Hash::make(Str::random(12)),
                'role_id' => $clientRole->id,
            ]
        );

        // Crée ou met à jour le client lié à cet utilisateur
        $client = Client::updateOrCreate(
            ['user_id' => $user->id],
            [
                // 'name'    => $nomClient,
                // 'email'   => $emailClient,
                'phone'   => $validated['telephone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]
        );

        // Crée l'intervention
        $intervention = $client->interventions()->create([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            'status' => StatutEnum::Nouvelle,
            'priority' => PrioriteEnum::Basse,
        ]);

        // ------------------------------
        // Gestion des images (max 3)
        // ------------------------------
        if ($request->hasFile('images')) {

            if (count($request->file('images')) > 3) {
                return back()->withErrors(['images' => 'Maximum 3 images autorisées.'])->withInput();
            }

            $manager = new ImageManager(new Driver());

            foreach ($request->file('images') as $imageFile) {

                // Sauvegarde de l'original
                $filename = time() . '_' . $imageFile->getClientOriginalName();
                $path = $imageFile->storeAs('interventions', $filename, 'public');

                // Chemin miniature
                $thumbnailPath = 'interventions/thumbnails/thumb_' . $filename;

                // Lecture via V3
                $img = $manager->read($imageFile->getRealPath());

                // Redimensionnement
                $img->scale(width: 100);

                // Chemin complet pour la miniature
                $fullThumbnailPath = storage_path('app/public/' . $thumbnailPath);

                // Crée le dossier s'il n'existe pas
                if (!is_dir(dirname($fullThumbnailPath))) {
                    mkdir(dirname($fullThumbnailPath), 0777, true);
                }

                // Sauvegarde miniature
                $img->save($fullThumbnailPath);

                // Enregistrement en BDD
                $intervention->images()->create([
                    'path' => $path,
                    'thumbnail_path' => $thumbnailPath,
                ]);
            }
        }

        // Message flash selon si client créé ou existant
        $message = $client->wasRecentlyCreated
            ? 'Votre compte client a été créé et votre demande est enregistrée. Connectez-vous à votre espace client pour suivre le dossier.'
            : 'Nous avons bien enregistré votre nouvelle demande d\'intervention. Connectez-vous à votre espace client pour suivre le dossier.';

        return redirect()->route('homepage')->with('success', $message);
    }

    public function edit(Intervention $intervention)
    {
        return view('interventions.edit', compact('intervention'));
    }

    public function update(UpdateInterventionRequest $request, Intervention $intervention)
    {
        $this->authorize('update', $intervention);
        $validated = $request->validated();

        $intervention->update($validated);

        return redirect()->route('interventions.show', $intervention)
            ->with('success', 'Intervention mise à jour avec succès.');
    }

    public function destroy(Intervention $intervention)
    {
        foreach ($intervention->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            if ($image->thumbnail_path && Storage::disk('public')->exists($image->thumbnail_path)) {
                Storage::disk('public')->delete($image->thumbnail_path);
            }
        }
        $this->authorize('delete', $intervention);

        $intervention->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Intervention supprimée avec succès.');
    }

    public function destroyImage(Image $image)
    {
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        if ($image->thumbnail_path && Storage::disk('public')->exists($image->thumbnail_path)) {
            Storage::disk('public')->delete($image->thumbnail_path);
        }

        $image->delete();

        return back()->with('success', 'Image supprimée avec succès.');
    }

     public function reassign(Request $request, Intervention $intervention)
    {
        $this->authorize('reassign', $intervention);

        $validated = $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $intervention->update([
            'technician_id' => $validated['technician_id'],
        ]);

        return redirect()->route('interventions.show', $intervention)
                        ->with('success', 'Technicien réassigné avec succès.');
    }
}
