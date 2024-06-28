<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition($productType = null): array
    {
        $brand = Brand::factory()->create();
        $type = $productType ?? \App\Enums\Product\ProductType::DEFAULT;
        $price = $this->faker->randomFloat(2, 10, 15);
        $vat_rate = \App\Enums\Product\VatRate::TWENTY;
        $vat_multiplier = 1 + ($vat_rate / 100);

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'reference' => $this->faker->unique()->numerify('REF###'),
            'brand_id' => $brand->id,
            'purchase_price' => $price,
            'selling_price' => $price * 1.2,  // assuming a markup of 20%
            'selling_price_with_vat' => $price * 1.2 * $vat_multiplier,
            'vat_rate' => $vat_rate,
            'product_type' => $type,
            'measurement_quantity' => $this->faker->numberBetween(200, 500),
            'measurement_unit' => $this->faker->randomElement(['kg', 'g', 'm', 'cm']),
            'stock' => $this->faker->numberBetween(1, 40),
            'alert_stock' => $this->faker->numberBetween(1, 5),
            'image' => $this->faker->imageUrl(),
            'user_id' => 1,
        ];
    }
}
