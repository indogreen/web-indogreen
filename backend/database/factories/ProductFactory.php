<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'model_series' => 'SERIES-'.fake()->bothify('##??'),
            'badge_tag' => fake()->randomElement(['NEW', 'POPULAR', null]),
            'short_description' => fake()->paragraph(1),
            'full_description' => fake()->paragraphs(3, true),
            'featured_image' => 'products/sample.webp',
            'datasheet_pdf' => 'datasheets/sample.pdf',
            'is_featured' => fake()->boolean(30),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
