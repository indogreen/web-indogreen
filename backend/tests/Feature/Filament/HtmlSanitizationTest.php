<?php

use App\Models\Page;
use App\Models\Product;
use App\Models\Solution;
use App\Services\HtmlSanitizerService;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('html sanitizer strips dangerous script tags and event handlers', function () {
    $dirty = '<p>Halo Dunia</p><script>alert("xss")</script><a href="javascript:steal()" onclick="hack()">Klik</a>';

    $clean = HtmlSanitizerService::sanitize($dirty);

    expect($clean)->not->toContain('<script>')
        ->and($clean)->not->toContain('alert(')
        ->and($clean)->not->toContain('onclick')
        ->and($clean)->not->toContain('javascript:')
        ->and($clean)->toContain('<p>Halo Dunia</p>');
});

test('product model automatically sanitizes full_description attribute', function () {
    $dirtyHtml = '<h2>Fitur Produk</h2><p>Hemat daya</p><script>alert("bahaya")</script><img src="x" onerror="alert(1)">';

    $product = Product::factory()->create([
        'full_description' => $dirtyHtml,
    ]);

    expect($product->full_description)->not->toContain('<script>')
        ->and($product->full_description)->not->toContain('onerror')
        ->and($product->full_description)->toContain('<h2>Fitur Produk</h2>')
        ->and($product->full_description)->toContain('<p>Hemat daya</p>');
});

test('solution model automatically sanitizes system_architecture attribute', function () {
    $dirtyHtml = '<p>Arsitektur hybrid</p><iframe src="https://evil.com"></iframe><div onmouseover="evil()">Aman</div>';

    $solution = Solution::factory()->create([
        'system_architecture' => $dirtyHtml,
    ]);

    expect($solution->system_architecture)->not->toContain('<iframe')
        ->and($solution->system_architecture)->not->toContain('onmouseover')
        ->and($solution->system_architecture)->toContain('<p>Arsitektur hybrid</p>')
        ->and($solution->system_architecture)->toContain('Aman');
});

test('page model automatically sanitizes content attribute', function () {
    $dirtyHtml = '<h1>Tentang Kami</h1><svg onload="hack()"></svg><p>Profil resmi PT Indogreen</p>';

    $page = Page::factory()->create([
        'content' => $dirtyHtml,
    ]);

    expect($page->content)->not->toContain('onload')
        ->and($page->content)->toContain('<h1>Tentang Kami</h1>')
        ->and($page->content)->toContain('<p>Profil resmi PT Indogreen</p>');
});
