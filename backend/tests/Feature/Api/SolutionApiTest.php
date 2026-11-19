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

test('solutions endpoints list active solutions and return comprehensive detail with products', function () {
    $solutionActive = Solution::factory()->create([
        'name' => 'PLTS On-Grid System',
        'system_type' => 'On-Grid',
        'included_components' => ['Modul PV Monocrystalline', 'Inverter On-Grid'],
        'benefits' => ['Hemat tagihan PLN hingga 70%', 'Perawatan mudah'],
        'is_active' => true,
    ]);

    $cat = Category::factory()->create();
    $prod = Product::factory()->create(['category_id' => $cat->id, 'name' => 'Inverter PV 5kW', 'is_active' => true]);
    $solutionActive->products()->attach($prod->id);

    $solutionInactive = Solution::factory()->create([
        'name' => 'Solusi Eksperimental Rusak',
        'is_active' => false,
    ]);

    // List
    $resList = $this->getJson('/api/v1/solutions');
    $resList->assertOk()
        ->assertJsonFragment(['name' => 'PLTS On-Grid System'])
        ->assertJsonMissing(['name' => 'Solusi Eksperimental Rusak']);

    // Detail
    $resDetail = $this->getJson("/api/v1/solutions/{$solutionActive->slug}");
    $resDetail->assertOk()
        ->assertJsonPath('data.name', 'PLTS On-Grid System')
        ->assertJsonPath('data.included_components.0', 'Modul PV Monocrystalline')
        ->assertJsonPath('data.benefits.0', 'Hemat tagihan PLN hingga 70%')
        ->assertJsonPath('data.products.0.name', 'Inverter PV 5kW');

    // 404 for invalid slug
    $res404 = $this->getJson('/api/v1/solutions/solusi-gaib');
    $res404->assertNotFound()
        ->assertJson(['error_code' => 'RESOURCE_NOT_FOUND']);
});
