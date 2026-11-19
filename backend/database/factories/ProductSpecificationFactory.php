<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductSpecification>
 */
class ProductSpecificationFactory extends Factory
{
    protected $model = ProductSpecification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'spec_group' => fake()->randomElement(['Elektrikal', 'Baterai', 'Lampu', 'Mekanikal']),
            'spec_key' => fake()->words(2, true),
            'spec_value' => (string) fake()->numberBetween(10, 500),
            'spec_unit' => fake()->randomElement(['Wp', 'Ah', 'lm/W', 'V', 'kg', 'mm']),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
