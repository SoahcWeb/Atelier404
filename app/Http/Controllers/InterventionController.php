<?php

namespace App\Http\Controllers;

use App\Enums\PrioriteEnum;
use App\Enums\StatutEnum;
use App\Models\Intervention;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email',
            'telephone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:200',
            'appareil' => 'required|string|max:100',
            'description_probleme' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('images') && count($request->file('images')) > 3) {
            return back()->withErrors(['images' => 'Maximum 3 images autorisées.'])->withInput();
        }

        // Création / récupération du user + client
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $nomClient = trim($validated['nom'] ?? '') ?: 'Client sans nom';
        $emailClient = $validated['email'];

        $user = User::firstOrCreate(
            ['email' => $emailClient],
            [
                'name' => $nomClient,
                'password' => Hash::make(Str::random(12)),
                'role_id' => $clientRole->id,
            ]
        );

        $client = Client::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name'    => $nomClient,
                'email'   => $emailClient,
                'phone'   => $validated['telephone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]
        );

        $intervention = $client->interventions()->create([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
            'status' => StatutEnum::Nouvelle,
            'priority' => PrioriteEnum::Basse,
        ]);

        /* -----------------------------------------------------
         *  GESTION DES IMAGES — COMPATIBLE INTERVENTION V3
         * ----------------------------------------------------- */
        if ($request->hasFile('images')) {

            // ⚠ CORRECTION V3 : instancier le driver explicitement
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

                // Enregistrement BDD
                $intervention->images()->create([
                    'path' => $path,
                    'thumbnail_path' => $thumbnailPath,
                ]);
            }
        }

        $message = $client->wasRecentlyCreated
            ? 'Votre compte client a été créé et votre demande est enregistrée. Connectez-vous à votre espace client pour suivre le dossier.'
            : 'Nous avons bien enregistré votre nouvelle demande d\'intervention. Connectez-vous à votre espace client pour suivre le dossier.';

        return redirect()->route('homepage')->with('success', $message);
    }

    public function edit(Intervention $intervention)
    {
        return view('interventions.edit', compact('intervention'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $validated = $request->validate([
            'appareil' => 'required|string|max:100',
            'description_probleme' => 'required|string',
        ]);

        $intervention->update([
            'device_type' => $validated['appareil'],
            'description' => $validated['description_probleme'],
        ]);

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

        $intervention->delete();

        return redirect()->route('interventions.index')
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
}
