<?php

namespace Database\Factories;

use App\Enums\OfficeType;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Office>
 */
class OfficeFactory extends Factory
{
    protected $model = Office::class;

    public function definition(): array
    {
        return [
            'name' => 'Kantor '.fake()->city(),
            'office_type' => fake()->randomElement([OfficeType::HEAD_OFFICE, OfficeType::REPRESENTATIVE_OFFICE]),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'map_embed_url' => 'https://maps.google.com/?q=jakarta',
            'sort_order' => fake()->numberBetween(0, 5),
            'is_active' => true,
        ];
    }
}
