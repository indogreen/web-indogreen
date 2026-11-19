<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Solution;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('search endpoint matches products, solutions, and categories', function () {
    $cat = Category::factory()->create([
        'name' => 'PJU Tenaga Surya',
        'is_active' => true,
    ]);

    $prod = Product::factory()->create([
        'category_id' => $cat->id,
        'name' => 'Lampu PJU Helios Two In One',
        'model_series' => 'Helios',
        'is_active' => true,
    ]);

    $sol = Solution::factory()->create([
        'name' => 'Sistem Penerangan Jalan Mandiri Helios',
        'is_active' => true,
    ]);

    // Inactive product should be excluded
    Product::factory()->create([
        'category_id' => $cat->id,
        'name' => 'Lampu Helios Mati Nonaktif',
        'is_active' => false,
    ]);

    $res = $this->getJson('/api/v1/search?q=Helios');

    $res->assertOk()
        ->assertJsonFragment(['name' => 'Lampu PJU Helios Two In One'])
        ->assertJsonFragment(['name' => 'Sistem Penerangan Jalan Mandiri Helios'])
        ->assertJsonMissing(['name' => 'Lampu Helios Mati Nonaktif']);

    // Empty search returns empty result without error
    $emptyRes = $this->getJson('/api/v1/search?q=');
    $emptyRes->assertOk()
        ->assertJsonPath('data.products', [])
        ->assertJsonPath('data.solutions', [])
        ->assertJsonPath('data.categories', []);
});
