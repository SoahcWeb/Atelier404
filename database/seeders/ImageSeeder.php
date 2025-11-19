<?php

namespace Database\Seeders;

use App\Models\Intervention;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    public function run()
    {
        // Crée le répertoire où les images seront copiées
        Storage::makeDirectory('public/interventions');

        // Charge la liste des images depuis storage/app/public/interventions-images
        $sampleImages = Storage::files('public/interventions-images');

        // Si aucune image n'est trouvée, on avertit l’utilisateur et on arrête l’exécution
        if (empty($sampleImages)) {
            dump(" Aucune image trouvée dans storage/app/public/interventions-images. Ajoutez des images d'exemple d’abord.");
            return;
        }

        // On récupère toutes les interventions existantes
        $interventions = Intervention::all();

        foreach ($interventions as $intervention) {

            //Pour chaque intervention, on génère entre 1 et 3 images
            $count = rand(1, 3);

            for ($i = 0; $i < $count; $i++) {

                // Sélectionne une image aléatoire parmi les images disponibles
                $source = $sampleImages[array_rand($sampleImages)];

                // Génère un nom unique pour éviter les collisions
                $filename = uniqid() . '.' . pathinfo($source, PATHINFO_EXTENSION);

                // Copie l'image vers le dossier public final (public/storage/interventions)
                Storage::copy($source, 'public/interventions/' . $filename);

                // Crée une miniature (pour l'instant, copie identique)
                $thumbnail = 'thumb_' . $filename;
                Storage::copy($source, 'public/interventions/' . $thumbnail);

                // Enregistre l'image dans la base de données
                Image::create([
                    'intervention_id' => $intervention->id,
                    'path' => 'interventions/' . $filename,
                    'thumbnail_path' => 'interventions/' . $thumbnail,
                ]);
            }
        }
    }
}

