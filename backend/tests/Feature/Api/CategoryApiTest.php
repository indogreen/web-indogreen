<?php

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('categories list endpoint returns only active categories with product counts', function () {
    $catActive = Category::factory()->create([
        'name' => 'PJU Tenaga Surya',
        'is_active' => true,
    ]);

    Product::factory()->count(3)->create([
        'category_id' => $catActive->id,
        'is_active' => true,
    ]);

    // Inactive product should not inflate product count
    Product::factory()->create([
        'category_id' => $catActive->id,
        'is_active' => false,
    ]);

    $catInactive = Category::factory()->create([
        'name' => 'Kategori Kedaluwarsa',
        'is_active' => false,
    ]);

    $response = $this->getJson('/api/v1/product-categories');

    $response->assertOk()
        ->assertJsonFragment(['name' => 'PJU Tenaga Surya', 'products_count' => 3])
        ->assertJsonMissing(['name' => 'Kategori Kedaluwarsa']);

    // Check alias /categories
    $aliasResponse = $this->getJson('/api/v1/categories');
    $aliasResponse->assertOk()
        ->assertJsonFragment(['name' => 'PJU Tenaga Surya']);
});

test('category show endpoint returns category detail and active products or 404', function () {
    $cat = Category::factory()->create([
        'name' => 'PLTS Rooftop',
        'is_active' => true,
    ]);

    $prod1 = Product::factory()->create([
        'category_id' => $cat->id,
        'name' => 'Paket Atap 5kWp',
        'is_active' => true,
    ]);

    $prod2 = Product::factory()->create([
        'category_id' => $cat->id,
        'name' => 'Paket Atap Draft',
        'is_active' => false,
    ]);

    $response = $this->getJson("/api/v1/product-categories/{$cat->slug}");

    $response->assertOk()
        ->assertJsonPath('data.category.slug', $cat->slug)
        ->assertJsonFragment(['name' => 'Paket Atap 5kWp'])
        ->assertJsonMissing(['name' => 'Paket Atap Draft']);

    // Non-existent slug returns 404 JSON envelope
    $notFoundResponse = $this->getJson('/api/v1/product-categories/slug-ngawur-tidak-ada');
    $notFoundResponse->assertNotFound()
        ->assertJson([
            'success' => false,
            'error_code' => 'RESOURCE_NOT_FOUND',
        ]);
});
