<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create(['name' => \App\Models\Role::ADMIN]);
        \App\Models\Role::create(['name' => \App\Models\Role::TECHNICIAN]);
        \App\Models\Role::create(['name' => \App\Models\Role::CLIENT]);
    }
}
