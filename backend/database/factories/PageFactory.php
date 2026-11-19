<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'content' => '<p>'.fake()->paragraph().'</p>',
            'seo_title' => substr(ucfirst($title).' | PT Indogreen', 0, 60),
            'seo_description' => substr(fake()->sentence(10), 0, 160),
            'is_active' => true,
        ];
    }
}
