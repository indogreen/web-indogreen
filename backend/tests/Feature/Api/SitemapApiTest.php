<?php

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Solution;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('sitemap entries endpoint returns structured urls and lastmod for public routes', function () {
    $cat = Category::factory()->create(['slug' => 'pju-surya', 'is_active' => true]);
    Product::factory()->create(['category_id' => $cat->id, 'slug' => 'helios-60w', 'is_active' => true]);
    Solution::factory()->create(['slug' => 'plts-on-grid', 'is_active' => true]);
    Page::factory()->create(['slug' => 'tentang-kami', 'is_active' => true]);

    $res = $this->getJson('/api/v1/sitemap-entries');

    $res->assertOk()
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => ['url', 'lastmod', 'changefreq', 'priority'],
            ],
        ]);

    $urls = collect($res->json('data'))->pluck('url')->all();

    expect($urls)->toContain(rtrim(config('app.frontend_url', env('FRONTEND_URL', 'https://indogreen.id')), '/').'/')
        ->and($urls)->toContain(rtrim(config('app.frontend_url', env('FRONTEND_URL', 'https://indogreen.id')), '/').'/produk')
        ->and($urls)->toContain(rtrim(config('app.frontend_url', env('FRONTEND_URL', 'https://indogreen.id')), '/').'/produk/pju-surya')
        ->and($urls)->toContain(rtrim(config('app.frontend_url', env('FRONTEND_URL', 'https://indogreen.id')), '/').'/produk/pju-surya/helios-60w')
        ->and($urls)->toContain(rtrim(config('app.frontend_url', env('FRONTEND_URL', 'https://indogreen.id')), '/').'/solusi/plts-on-grid')
        ->and($urls)->toContain(rtrim(config('app.frontend_url', env('FRONTEND_URL', 'https://indogreen.id')), '/').'/tentang-kami');
});
