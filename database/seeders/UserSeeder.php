<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Client;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);

        User::create([
            'name' => 'Technician',
            'email' => 'technician@test.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        $clientRoleId = Role::where('name', 'Client')->first()->id;

        $testClient = User::create([
            'name' => 'ClienteTest',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
            'role_id' => $clientRoleId,
        ]);


        Client::create([
            'user_id' => $testClient->id,
            'phone' => '123456789',
            'address' => 'Calle de prueba 123',
        ]);


        User::factory(5)->create([
                    'role_id' => Role::where('name', Role::TECHNICIAN)->first()->id,
                ]);

        User::factory(10)->create([
                    'role_id' => Role::where('name', Role::CLIENT)->first()->id,
                ])->each(function ($user) {
                    Client::create([
                        'user_id' => $user->id,
                        'phone' => fake()->phoneNumber(),
                        'address' => fake()->address(),
                    ]);
                });
            }
}
