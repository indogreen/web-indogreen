<?php

use App\Models\Page;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('page show endpoint returns active page content or 404', function () {
    $page = Page::factory()->create([
        'title' => 'Kebijakan Privasi',
        'content' => '<p>Perlindungan data pribadi pengguna sesuai UU PDP.</p>',
        'seo_title' => 'Kebijakan Privasi PT Indogreen',
        'is_active' => true,
    ]);

    $inactivePage = Page::factory()->create([
        'title' => 'Halaman Dihapus',
        'is_active' => false,
    ]);

    $res = $this->getJson("/api/v1/pages/{$page->slug}");
    $res->assertOk()
        ->assertJsonPath('data.title', 'Kebijakan Privasi')
        ->assertJsonPath('data.content', '<p>Perlindungan data pribadi pengguna sesuai UU PDP.</p>')
        ->assertJsonPath('data.seo_title', 'Kebijakan Privasi PT Indogreen');

    // Inactive page returns 404
    $resInactive = $this->getJson("/api/v1/pages/{$inactivePage->slug}");
    $resInactive->assertNotFound();

    // Invalid slug returns 404
    $res404 = $this->getJson('/api/v1/pages/halaman-tidak-pernah-ada');
    $res404->assertNotFound()
        ->assertJson(['error_code' => 'RESOURCE_NOT_FOUND']);
});
