<?php

use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Solution;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('home endpoint returns active slides, featured products, solutions, and company profile', function () {
    // Active slide
    HeroSlide::factory()->create([
        'title' => 'Slide Aktif',
        'is_active' => true,
        'sort_order' => 1,
    ]);
    // Inactive slide
    HeroSlide::factory()->create([
        'title' => 'Slide Nonaktif',
        'is_active' => false,
    ]);

    $category = Category::factory()->create(['is_active' => true]);

    // Active featured product
    Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Produk Unggulan',
        'is_featured' => true,
        'is_active' => true,
    ]);
    // Inactive product
    Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Produk Nonaktif',
        'is_featured' => true,
        'is_active' => false,
    ]);

    // Active solution
    Solution::factory()->create([
        'name' => 'Solusi Aktif',
        'is_active' => true,
    ]);
    // Inactive solution
    Solution::factory()->create([
        'name' => 'Solusi Nonaktif',
        'is_active' => false,
    ]);

    SiteSetting::factory()->create([
        'company_name' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
    ]);

    $response = $this->getJson('/api/v1/home');

    $response->assertOk()
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'hero_slides',
                'featured_products',
                'solutions',
                'categories',
                'company',
            ],
            'meta',
        ])
        ->assertJsonFragment(['title' => 'Slide Aktif'])
        ->assertJsonMissing(['title' => 'Slide Nonaktif'])
        ->assertJsonFragment(['name' => 'Produk Unggulan'])
        ->assertJsonMissing(['name' => 'Produk Nonaktif'])
        ->assertJsonFragment(['name' => 'Solusi Aktif'])
        ->assertJsonMissing(['name' => 'Solusi Nonaktif']);

    // Headers check
    $response->assertHeader('Cache-Control');
    $response->assertHeader('ETag');
    $response->assertHeader('X-Content-Version');

    $etag = $response->headers->get('ETag');

    // 304 Not Modified check
    $cachedResponse = $this->withHeaders(['If-None-Match' => $etag])->getJson('/api/v1/home');
    $cachedResponse->assertStatus(304);
});
