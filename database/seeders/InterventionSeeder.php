<?php

namespace Database\Seeders;

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
        // Obtener roles
        $technicianRoleId = Role::where('name', Role::TECHNICIAN)->first()->id;
        $clientRoleId     = Role::where('name', Role::CLIENT)->first()->id;

        if (!$technicianRoleId || !$clientRoleId) {
            dd('No se encontraron roles Technician o Client');
        }

        // Obtener todos los clientes
        $clients = User::where('role_id', $clientRoleId)->get();

        if ($clients->isEmpty()) {
            dd('No hay usuarios con rol Client');
        }

        // Obtener todos los técnicos (solo IDs)
        $technicianIds = User::where('role_id', $technicianRoleId)->pluck('id')->toArray();

        if (empty($technicianIds)) {
            dd('No hay técnicos disponibles para asignar intervenciones');
        }

        // Crear intervenciones
        foreach ($clients as $client) {
            Intervention::factory(rand(1, 3))->create([
                'client_id' => $client->id,
                'technician_id' => $technicianIds[array_rand($technicianIds)],
            ]);
        }
    }
}
