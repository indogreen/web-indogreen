<?php

use App\Enums\InquiryStatus;
use App\Models\Category;
use App\Models\CompanySetting;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Solution;
use App\Models\User;

test('all model factories create valid database records', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create();
    $spec = ProductSpecification::factory()->create();
    $solution = Solution::factory()->create();
    $inquiry = Inquiry::factory()->create();
    $setting = CompanySetting::factory()->create();

    expect($user->exists)->toBeTrue()
        ->and($category->exists)->toBeTrue()
        ->and($product->exists)->toBeTrue()
        ->and($spec->exists)->toBeTrue()
        ->and($solution->exists)->toBeTrue()
        ->and($inquiry->exists)->toBeTrue()
        ->and($setting->exists)->toBeTrue()
        ->and($inquiry->status)->toBeInstanceOf(InquiryStatus::class);
});
