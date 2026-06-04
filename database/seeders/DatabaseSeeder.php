<?php

namespace Database\Seeders;

use App\Models\Donnee;
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
        // Création sécurisée de votre compte administrateur s'il n'existe pas
        if (User::where('email', 'djuniossbks@gmail.com')->doesntExist()) {
            $admin = User::create([
                'name' => 'Djunioss',
                'email' => 'djuniossbks@gmail.com',
                'password' => Hash::make(env('DB_PASSWORD')), // Récupère le mot de passe Aiven sur Render
                'role' => 'admin',
            ]);

            // Données initiales minimales pour l'admin pour éviter la surcharge mémoire
            if (class_exists(\App\Models\Donnee::class)) {
                Donnee::factory(4)->create([
                    'utilisateur_id' => $admin->id,
                ]);
            }
        }

        // Utilisateur standard de test s'il n'existe pas
        if (User::where('email', 'jean@example.com')->doesntExist()) {
            $utilisateur = User::create([
                'name' => 'Jean Dupont',
                'email' => 'jean@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);

            if (class_exists(\App\Models\Donnee::class)) {
                Donnee::factory(4)->create([
                    'utilisateur_id' => $utilisateur->id,
                ]);
            }
        }
    }
}