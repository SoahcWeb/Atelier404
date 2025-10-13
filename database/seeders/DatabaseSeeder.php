<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Intervention;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création d’un admin
        User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@atelier404.local',
            'password' => bcrypt('admin123'),
            'role' => 'Admin',
        ]);

        // Création de techniciens
        User::factory(5)->create(['role' => 'Technicien']);

        // Création de clients et interventions associées
        Client::factory(10)
            ->has(Intervention::factory()->count(3))
            ->create();
    }
}

