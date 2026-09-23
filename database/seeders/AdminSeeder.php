<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) env('ADMIN_EMAIL', ''));
        $password = (string) env('ADMIN_PASSWORD', '');
        $name = trim((string) env('ADMIN_NAME', 'Administrateur Sozo Habitat'));

        if ($email === '' || $password === '') {
            $this->command?->warn(
                'Administrateur non créé : ADMIN_EMAIL et ADMIN_PASSWORD doivent être définis.'
            );

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->command?->error('Administrateur non créé : ADMIN_EMAIL est invalide.');

            return;
        }

        if (mb_strlen($password) < 12) {
            $this->command?->error(
                'Administrateur non créé : ADMIN_PASSWORD doit contenir au moins 12 caractères.'
            );

            return;
        }

        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->role !== 'admin') {
                $this->command?->error(
                    'Administrateur non créé : cette adresse e-mail appartient déjà à un compte non administrateur.'
                );
            } else {
                $this->command?->info('Le compte administrateur existe déjà.');
            }

            return;
        }

        User::create([
            'name' => $name !== '' ? $name : 'Administrateur Sozo Habitat',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->command?->info('Compte administrateur Sozo Habitat créé avec succès.');
    }
}
