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
        // Création de votre compte Administrateur principal basé sur la variable d'environnement
        $admin = User::factory()->admin()->create([
            'name' => 'Djunioss',
            'email' => 'djuniossbks@gmail.com',
            // Utilise automatiquement le mot de passe Aiven configuré sur Render
            'password' => Hash::make(env('DB_PASSWORD')), 
        ]);

        // Un utilisateur de test standard (si vous souhaitez le garder)
        $utilisateur = User::factory()->create([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'password' => Hash::make('password'),
        ]);

        // Génération des données de test liées aux comptes
        Donnee::factory(8)->create([
            'utilisateur_id' => $utilisateur->id,
        ]);

        Donnee::factory(4)->create([
            'utilisateur_id' => $admin->id,
        ]);
    }
}
