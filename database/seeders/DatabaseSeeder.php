<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Intervention;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UserSeeder::class);


        // Création de clients et interventions associées
        Client::create([
                'name' => 'client',
                'email' => 'client@atelier404.local',
                'phone' => '0123456789',
                
        ]);

        Client::factory(10)
            ->has(Intervention::factory()->count(3))
            ->create();
    }
}

