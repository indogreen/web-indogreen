<?php

use App\Models\Category;
use App\Models\Product;

test('scope active filters only active records', function () {
    Category::factory()->create(['name' => 'Active Item', 'is_active' => true]);
    Category::factory()->create(['name' => 'Inactive Item', 'is_active' => false]);

    $activeCategories = Category::active()->get();

    expect($activeCategories)->toHaveCount(1)
        ->and($activeCategories->first()->name)->toBe('Active Item');
});

test('scope ordered sorts records by sort_order ascending', function () {
    $second = Category::factory()->create(['name' => 'Second', 'sort_order' => 20]);
    $first = Category::factory()->create(['name' => 'First', 'sort_order' => 5]);

    $ordered = Category::ordered()->get();

    expect($ordered->first()->id)->toBe($first->id)
        ->and($ordered->last()->id)->toBe($second->id);
});

test('scope featured filters featured products', function () {
    Product::factory()->create(['is_featured' => true]);
    Product::factory()->create(['is_featured' => false]);

    expect(Product::featured()->count())->toBe(1);
});

test('slug is generated automatically and is unique on creation', function () {
    $cat1 = Category::create([
        'name' => 'PJU Tenaga Surya',
        'is_active' => true,
    ]);

    $cat2 = Category::create([
        'name' => 'PJU Tenaga Surya',
        'is_active' => true,
    ]);

    expect($cat1->slug)->toBe('pju-tenaga-surya')
        ->and($cat2->slug)->toBe('pju-tenaga-surya-1');
});

test('slug does not change automatically when name is updated to ensure url stability', function () {
    $category = Category::create([
        'name' => 'Original Name',
        'is_active' => true,
    ]);

    expect($category->slug)->toBe('original-name');

    $category->update(['name' => 'Brand New Name']);
    $category->refresh();

    expect($category->name)->toBe('Brand New Name')
        ->and($category->slug)->toBe('original-name');
});
