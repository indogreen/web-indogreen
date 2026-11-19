<?php

use App\Enums\OfficeType;
use App\Models\Office;
use App\Models\SiteSetting;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('settings and company endpoints return site identity, offices, and social links', function () {
    SiteSetting::factory()->create([
        'company_name' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
        'email' => 'support@indogreen.id',
        'phone' => '+62 251 754 1234',
        'facebook_url' => 'https://facebook.com/indogreen',
    ]);

    // Active office
    Office::factory()->create([
        'name' => 'Kantor Utama Bogor',
        'office_type' => OfficeType::HEAD_OFFICE,
        'is_active' => true,
    ]);

    // Inactive office
    Office::factory()->create([
        'name' => 'Kantor Rahasia Tutup',
        'office_type' => OfficeType::REPRESENTATIVE_OFFICE,
        'is_active' => false,
    ]);

    $response = $this->getJson('/api/v1/settings');

    $response->assertOk()
        ->assertJsonPath('data.company_name', 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT')
        ->assertJsonPath('data.email', 'support@indogreen.id')
        ->assertJsonPath('data.social_links.facebook', 'https://facebook.com/indogreen')
        ->assertJsonFragment(['name' => 'Kantor Utama Bogor'])
        ->assertJsonMissing(['name' => 'Kantor Rahasia Tutup']);

    // Check alias /company
    $aliasResponse = $this->getJson('/api/v1/company');
    $aliasResponse->assertOk()
        ->assertJsonPath('data.company_name', 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT');
});
