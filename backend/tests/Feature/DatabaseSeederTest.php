<?php

use App\Models\Category;
use App\Models\CompanySetting;
use App\Models\Product;
use App\Models\Solution;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('database seeder creates admin user with admin role', function () {
    $email = env('ADMIN_EMAIL', 'admin@indogreen.id');
    $user = User::where('email', $email)->first();

    expect($user)->not->toBeNull()
        ->and($user->hasRole('admin'))->toBeTrue()
        ->and($user->can('access-admin'))->toBeTrue();
});

test('database seeder creates 4 categories from docs/06', function () {
    $slugs = [
        'pju-tenaga-surya',
        'plts-residential',
        'solar-home-system',
        'aksesoris-kelistrikan',
    ];

    expect(Category::count())->toBe(4);

    foreach ($slugs as $slug) {
        expect(Category::where('slug', $slug)->exists())->toBeTrue();
    }
});

test('database seeder creates 5 solutions from docs/06', function () {
    $slugs = [
        'plts-on-grid',
        'plts-on-grid-hybrid',
        'plts-off-grid',
        'plts-off-grid-hybrid',
        'backup-power-ups',
    ];

    expect(Solution::count())->toBe(5);

    foreach ($slugs as $slug) {
        expect(Solution::where('slug', $slug)->exists())->toBeTrue();
    }
});

test('database seeder creates products with specifications', function () {
    $products = Product::with('specifications')->get();

    expect($products)->not->toBeEmpty();

    $helios = Product::where('slug', 'pju-two-in-one-helios-series')->first();
    expect($helios)->not->toBeNull()
        ->and($helios->specifications)->not->toBeEmpty();
});

test('database seeder sets up company profile and todo-content markers', function () {
    $companyName = CompanySetting::where('key_name', 'company_name')->first();
    $whatsapp = CompanySetting::where('key_name', 'whatsapp_number')->first();

    expect($companyName?->value_content)->toBe('PT. INDOGREEN TECHNOLOGY AND MANAGEMENT')
        ->and($whatsapp?->value_content)->toContain('TODO-CONTENT');
});
