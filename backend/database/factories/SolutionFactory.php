<?php

namespace Database\Factories;

use App\Models\Solution;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Solution>
 */
class SolutionFactory extends Factory
{
    protected $model = Solution::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'system_type' => fake()->randomElement(['On-Grid', 'Hybrid', 'Off-Grid', 'UPS']),
            'summary' => fake()->paragraph(),
            'system_architecture' => fake()->paragraphs(2, true),
            'included_components' => ['Solar Panels', 'Inverter', 'Mounting Bracket', 'Baterai LiFePO4'],
            'benefits' => ['Hemat Biaya Listrik', 'Energi Mandiri', 'Garansi Resmi'],
            'diagram_image' => 'solutions/diagram.webp',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
