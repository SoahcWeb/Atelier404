<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin',
    'email' => 'admin@atelier404.local',
    'password' => Hash::make('admin123'),
    'role' => 'Admin'
]);

User::create([
    'name' => 'Jesus',
    'email' => 'jesus@atelier404.local',
    'password' => Hash::make('jesus123'),
    'role' => 'Technicien'
]);
