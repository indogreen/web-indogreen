<?php

use App\Models\Category;
use App\Models\CompanySetting;
use App\Models\Product;
use App\Models\Solution;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('category registers category_image collection and supports alt text', function () {
    $category = Category::factory()->create();
    $file = UploadedFile::fake()->image('category.jpg');

    $media = $category->addMedia($file)
        ->withCustomProperties(['alt' => 'Gambar Kategori PJU'])
        ->toMediaCollection('category_image');

    expect($media->collection_name)->toBe('category_image')
        ->and($media->getCustomProperty('alt'))->toBe('Gambar Kategori PJU')
        ->and($category->getFirstMedia('category_image'))->not->toBeNull();
});

test('product registers gallery and datasheet collections', function () {
    $product = Product::factory()->create();
    $image = UploadedFile::fake()->image('solar-lamp.png');
    $pdf = UploadedFile::fake()->createWithContent('datasheet.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\ntrailer\n<<>>\n%%EOF");

    $imageMedia = $product->addMedia($image)
        ->withCustomProperties(['alt' => 'Foto Lampu Solar'])
        ->toMediaCollection('product_gallery');

    $pdfMedia = $product->addMedia($pdf)
        ->toMediaCollection('product_datasheet');

    expect($imageMedia->collection_name)->toBe('product_gallery')
        ->and($imageMedia->getCustomProperty('alt'))->toBe('Foto Lampu Solar')
        ->and($pdfMedia->collection_name)->toBe('product_datasheet');
});

test('solution and company settings register hero collections', function () {
    $solution = Solution::factory()->create();
    $setting = CompanySetting::factory()->create();

    $desktopImage = UploadedFile::fake()->image('hero-desktop.webp');
    $mobileImage = UploadedFile::fake()->image('hero-mobile.webp');

    $solutionMedia = $solution->addMedia($desktopImage)
        ->toMediaCollection('hero_desktop');

    $settingMedia = $setting->addMedia($mobileImage)
        ->toMediaCollection('hero_mobile');

    expect($solutionMedia->collection_name)->toBe('hero_desktop')
        ->and($settingMedia->collection_name)->toBe('hero_mobile');
});
