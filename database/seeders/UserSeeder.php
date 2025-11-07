<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

User::create([
    'name' => 'Admin',
    'email' => 'admin@atelier404.local',
    'password' => Hash::make('admin123'),
    'role_id' => 1,
]);

User::create([
    'name' => 'Jesus',
    'email' => 'jesus@atelier404.local',
    'password' => Hash::make('jesus123'),
    'role_id' => 2,
]);

User::factory(5)->create(['role_id' => 2]);
    }
}
