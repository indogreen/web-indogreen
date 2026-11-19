<?php

namespace Database\Factories;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone_whatsapp' => fake()->phoneNumber(),
            'company_organization' => fake()->company(),
            'product_id' => null,
            'solution_id' => null,
            'subject' => fake()->sentence(4),
            'message_content' => fake()->paragraph(),
            'consent' => true,
            'status' => InquiryStatus::PENDING,
            'ip_address' => fake()->ipv4(),
            'ip_hash' => hash('sha256', fake()->ipv4()),
            'user_agent' => fake()->userAgent(),
            'internal_notes' => null,
        ];
    }
}
