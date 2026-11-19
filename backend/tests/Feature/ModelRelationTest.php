<?php

use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Solution;

test('category has many products and product belongs to category', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    expect($category->products)->toHaveCount(1)
        ->and($category->products->first()->id)->toBe($product->id)
        ->and($product->category->id)->toBe($category->id);
});

test('product has many specifications and specification belongs to product', function () {
    $product = Product::factory()->create();
    $spec = ProductSpecification::factory()->create(['product_id' => $product->id]);

    expect($product->specifications)->toHaveCount(1)
        ->and($product->specifications->first()->id)->toBe($spec->id)
        ->and($spec->product->id)->toBe($product->id);
});

test('inquiry can reference product and solution', function () {
    $product = Product::factory()->create();
    $solution = Solution::factory()->create();

    $inquiry = Inquiry::factory()->create([
        'product_id' => $product->id,
        'solution_id' => $solution->id,
    ]);

    expect($inquiry->product->id)->toBe($product->id)
        ->and($inquiry->solution->id)->toBe($solution->id)
        ->and($product->inquiries)->toHaveCount(1)
        ->and($solution->inquiries)->toHaveCount(1);
});
