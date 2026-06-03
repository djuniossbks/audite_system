<?php

namespace Database\Seeders;

use App\Models\Donnee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $utilisateur = User::factory()->create([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'password' => 'password',
        ]);

        Donnee::factory(8)->create([
            'utilisateur_id' => $utilisateur->id,
        ]);

        Donnee::factory(4)->create([
            'utilisateur_id' => $admin->id,
        ]);
    }
}
