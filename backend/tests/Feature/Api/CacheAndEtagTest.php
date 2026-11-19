<?php

use App\Models\Category;
use App\Models\Product;
use App\Services\ContentCacheService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('etag and 304 not modified negotiation works for api get requests', function () {
    $cat = Category::factory()->create();
    Product::factory()->create(['category_id' => $cat->id, 'name' => 'Lampu Awal', 'is_active' => true]);

    $res1 = $this->getJson('/api/v1/products');
    $res1->assertOk();

    $etag = $res1->headers->get('ETag');
    expect($etag)->not->toBeNull();

    // Conditional request with matching If-None-Match
    $res304 = $this->withHeaders(['If-None-Match' => $etag])->getJson('/api/v1/products');
    $res304->assertStatus(304);
});

test('model updates automatically bump content version and invalidate cached responses', function () {
    $cat = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $cat->id, 'name' => 'Produk Versi 1', 'is_active' => true]);

    $res1 = $this->getJson('/api/v1/products');
    $res1->assertOk()
        ->assertJsonFragment(['name' => 'Produk Versi 1']);

    $initialVersion = (int) $res1->headers->get('X-Content-Version');

    // Updating product triggers ContentVersionObserver::saved
    $product->update(['name' => 'Produk Versi 2 Diperbarui']);

    $newVersion = ContentCacheService::getVersion();
    expect($newVersion)->toBeGreaterThan($initialVersion);

    // Subsequent request receives fresh data with new content version
    $res2 = $this->getJson('/api/v1/products');
    $res2->assertOk()
        ->assertJsonFragment(['name' => 'Produk Versi 2 Diperbarui'])
        ->assertJsonMissing(['name' => 'Produk Versi 1']);

    expect((int) $res2->headers->get('X-Content-Version'))->toBe($newVersion);
});
