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
        $this->call(InterventionSeeder::class);
    }

}
