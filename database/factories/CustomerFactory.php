<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'postcode' => $this->faker->numberBetween(10000, 99999),
            'notes' => $this->faker->text,
            'sector_id' => 1,
            'user_id' => 1,
        ];
    }

    public function sameSector(int $sectorId): self
    {
        return $this->state([
            'sector_id' => $sectorId,
        ]);
    }
}
