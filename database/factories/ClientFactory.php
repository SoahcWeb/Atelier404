<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ];
    }
}
