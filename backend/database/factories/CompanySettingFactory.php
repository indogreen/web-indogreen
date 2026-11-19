<?php

namespace Database\Factories;

use App\Models\CompanySetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanySetting>
 */
class CompanySettingFactory extends Factory
{
    protected $model = CompanySetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key_name' => fake()->unique()->slug(2),
            'value_content' => fake()->sentence(),
            'value_type' => 'text',
            'group_type' => fake()->randomElement(['contact', 'general', 'social', 'stats']),
            'is_public' => true,
        ];
    }
}
