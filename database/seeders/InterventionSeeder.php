<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Intervention;

class InterventionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technicianRoleId = Role::where('name', 'technician')->first()->id;
        $clientRoleId = Role::where('name', 'client')->first()->id;


if (!$clientRoleId) {
    dd('No se encontró el rol Client');
}

$clients = User::where('role_id', $clientRoleId)->get();

if ($clients->isEmpty()) {
    dd('No hay usuarios con rol Client');
}



        foreach ($clients as $client) {
            Intervention::factory(rand(1, 3))->create([
                'client_id' => $client->id,
                'technician_id' => User::where('role_id', $technicianRoleId)->inRandomOrder()->first()->id,
            ]);
        }
    }
}
