<?php

namespace Database\Factories;

use App\Models\Donnee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donnee>
 */
class DonneeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'utilisateur_id' => User::factory(),
        ];
    }
}
