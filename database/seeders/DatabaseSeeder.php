<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@sozohabitat.ci',
            ],
            [
                'name' => 'Administrateur Sozo Habitat',
                'password' => Hash::make('Sozo@2026Admin'),
            ]
        );

        $this->call([
            PropertySeeder::class,
        ]);
    }
}