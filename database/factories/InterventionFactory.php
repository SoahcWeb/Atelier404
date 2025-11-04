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
            'technician_id' => User::inRandomOrder()->where('role', 'technician')->first()?->id ?? User::factory()->create(['role' => 'technician'])->id,
            'description' => $this->faker->sentence(10),
            'device_type' => $this->faker->randomElement(['PC', 'Smartphone', 'Tablette', 'Imprimante']),
            'priority' => $this->faker->randomElement(['basse', 'normale', 'haute']),
            'status' => $this->faker->randomElement(['nouvelle', 'diagnostic', 'en_reparation', 'termine', 'non_reparable']),
            'scheduled_at' => $this->faker->dateTimeBetween('now', '+15 days'),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
