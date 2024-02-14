<?php

namespace Database\Factories;

use App\Models\Postcode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Postcode>
 */
class PostcodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'postcode' => str_replace(' ', '', $this->faker->unique()->numberBetween(10000, 99999)),
            'city' => $this->faker->city,
        ];
    }

    /**
     * Specify the same sector_id for multiple postcodes.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function sameSector(int $sectorId): self
    {
        return $this->state([
            'sector_id' => $sectorId,
        ])->afterCreating(function (Postcode $postcode) {
            $postcode->update(['postcode' => str_replace(' ', '', $this->faker->unique()->numberBetween(10000, 99999))]);
        });
    }
}
