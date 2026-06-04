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
        $admin = User::updateOrCreate(
            ['email' => 'djuniossbks@gmail.com'],
            [
                'name' => 'Djunioss',
                'password' => Hash::make(env('DB_PASSWORD')),
                'role' => 'admin',
            ]
        );

        $utilisateur = User::firstOrCreate(
            ['email' => 'jean@example.com'],
            User::factory()->make([
                'name' => 'Jean Dupont',
                'email' => 'jean@example.com',
                'role' => 'utilisateur',
            ])->getAttributes()
        );

        Donnee::factory(8)->create([
            'utilisateur_id' => $utilisateur->id,
        ]);

        Donnee::factory(4)->create([
            'utilisateur_id' => $admin->id,
        ]);
    }
}
