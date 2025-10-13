<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterventionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'user_id' => User::inRandomOrder()->where('role', 'Technicien')->first()?->id ?? User::factory()->create(['role' => 'Technicien'])->id,
            'description' => $this->faker->sentence(10),
            'type_appareil' => $this->faker->randomElement(['PC', 'Smartphone', 'Tablette', 'Imprimante']),
            'priorite' => $this->faker->randomElement(['basse', 'normale', 'haute']),
            'statut' => $this->faker->randomElement(['nouvelle', 'diagnostic', 'en_reparation', 'termine', 'non_reparable']),
            'date_prevue' => $this->faker->dateTimeBetween('now', '+15 days'),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
