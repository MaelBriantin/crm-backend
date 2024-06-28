<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sector>
 */
class SectorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Récupère un utilisateur aléatoire existant ou crée-en un nouveau si nécessaire
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'name' => $this->faker->unique()->word,
            'user_id' => $user->id,
        ];
    }
}
