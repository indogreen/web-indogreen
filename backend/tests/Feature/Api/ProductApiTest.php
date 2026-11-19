<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Solution;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('products endpoint returns paginated active items and supports filters', function () {
    $cat1 = Category::factory()->create(['name' => 'Kategori PJU', 'is_active' => true]);
    $cat2 = Category::factory()->create(['name' => 'Kategori Solar Home', 'is_active' => true]);

    $pju1 = Product::factory()->create([
        'category_id' => $cat1->id,
        'name' => 'Lampu Helios 60W',
        'model_series' => 'Helios',
        'is_featured' => true,
        'is_active' => true,
    ]);

    $pju2 = Product::factory()->create([
        'category_id' => $cat1->id,
        'name' => 'Lampu Jupiter 80W',
        'model_series' => 'Jupiter',
        'is_featured' => false,
        'is_active' => true,
    ]);

    $shs1 = Product::factory()->create([
        'category_id' => $cat2->id,
        'name' => 'Paket SHS Pedesaan 100Wp',
        'model_series' => 'SHS',
        'is_featured' => true,
        'is_active' => true,
    ]);

    $inactive = Product::factory()->create([
        'category_id' => $cat1->id,
        'name' => 'Produk Arsip Mati',
        'is_active' => false,
    ]);

    // 1. Base list
    $res = $this->getJson('/api/v1/products');
    $res->assertOk()
        ->assertJsonStructure([
            'success',
            'message',
            'data',
            'meta' => ['current_page', 'last_page', 'per_page', 'total'],
        ])
        ->assertJsonFragment(['name' => 'Lampu Helios 60W'])
        ->assertJsonMissing(['name' => 'Produk Arsip Mati']);

    // 2. Filter by category
    $resCat = $this->getJson("/api/v1/products?category={$cat1->slug}");
    $resCat->assertOk()
        ->assertJsonFragment(['name' => 'Lampu Helios 60W'])
        ->assertJsonFragment(['name' => 'Lampu Jupiter 80W'])
        ->assertJsonMissing(['name' => 'Paket SHS Pedesaan 100Wp']);

    // 3. Filter by search query
    $resSearch = $this->getJson('/api/v1/products?q=Jupiter');
    $resSearch->assertOk()
        ->assertJsonFragment(['name' => 'Lampu Jupiter 80W'])
        ->assertJsonMissing(['name' => 'Lampu Helios 60W']);

    // 4. Filter by featured
    $resFeatured = $this->getJson('/api/v1/products?featured=1');
    $resFeatured->assertOk()
        ->assertJsonFragment(['name' => 'Lampu Helios 60W'])
        ->assertJsonFragment(['name' => 'Paket SHS Pedesaan 100Wp'])
        ->assertJsonMissing(['name' => 'Lampu Jupiter 80W']);
});

test('product detail endpoints return complete technical specifications, solutions, and SEO', function () {
    $category = Category::factory()->create(['name' => 'PJU Tenaga Surya', 'is_active' => true]);

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'PJU Two-In-One Helios 60W',
        'model_series' => 'TIO-HELIOS',
        'seo_title' => 'Lampu PJU Helios 60W Berkualitas',
        'seo_description' => 'Lampu PJU Solar Cell seri Helios Two-In-One.',
        'is_active' => true,
    ]);

    ProductSpecification::create([
        'product_id' => $product->id,
        'spec_group' => 'Optikal',
        'spec_key' => 'Daya Lampu',
        'spec_value' => '60',
        'spec_unit' => 'W',
        'sort_order' => 1,
    ]);

    $solution = Solution::factory()->create(['name' => 'Penerangan Jalan Bebas Emisi', 'is_active' => true]);
    $solution->products()->attach($product->id);

    // Detail via /products/{category_slug}/{product_slug}
    $res = $this->getJson("/api/v1/products/{$category->slug}/{$product->slug}");
    $res->assertOk()
        ->assertJsonPath('data.name', 'PJU Two-In-One Helios 60W')
        ->assertJsonPath('data.category.slug', $category->slug)
        ->assertJsonPath('data.seo_title', 'Lampu PJU Helios 60W Berkualitas')
        ->assertJsonPath('data.specifications_grouped.Optikal.0.key', 'Daya Lampu')
        ->assertJsonPath('data.specifications_grouped.Optikal.0.value', '60')
        ->assertJsonPath('data.solutions.0.name', 'Penerangan Jalan Bebas Emisi');

    // Detail via /products/{slug}
    $resSlug = $this->getJson("/api/v1/products/{$product->slug}");
    $resSlug->assertOk()
        ->assertJsonPath('data.name', 'PJU Two-In-One Helios 60W');

    // 404 for invalid slug
    $notFound = $this->getJson('/api/v1/products/produk-palsu-ngawur');
    $notFound->assertNotFound()
        ->assertJson(['error_code' => 'RESOURCE_NOT_FOUND']);
});
