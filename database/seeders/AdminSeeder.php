<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@sozohabitat.ci')],
            [
                'name' => 'Administrateur Sozo Habitat',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Sozo@2026Admin')),
                'role' => 'admin',
            ]
        );
    }
}