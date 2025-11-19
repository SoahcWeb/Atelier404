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
        $technicianRoleId = Role::where('name', Role::TECHNICIAN)->first()->id;
        $clientRoleId     = Role::where('name', Role::CLIENT)->first()->id;


    if (!$technicianRoleId || !$clientRoleId) {
                dd('No se encontraron roles Technician o Client');
            }

    $clients = User::where('role_id', $clientRoleId)->get();

    if ($clients->isEmpty()) {
        dd('No hay usuarios con rol Client');
    }

    $technicians = User::where('role_id', $technicianRoleId)->get();

    if (empty($technicians)) {
            dd('No hay técnicos disponibles para asignar intervenciones');
        }

    $techIndex = 0; // Para repartir en orden

        foreach ($clients as $client) {
            $numInterventions = rand(1, 3);

            for ($i = 0; $i < $numInterventions; $i++) {

                // Selecciona el técnico en orden (round-robin)
                $technician = $technicians[$techIndex];

                Intervention::factory()->create([
                    'client_id'     => $client->client->id,
                    'technician_id' => $technician->id,
                ]);

                // Avanza al siguiente técnico
                $techIndex = ($techIndex + 1) % $technicians->count();
            }
        }
    }
}
