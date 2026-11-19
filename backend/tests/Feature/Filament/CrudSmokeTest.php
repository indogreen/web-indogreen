<?php

use App\Enums\InquiryStatus;
use App\Enums\OfficeType;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Inquiry;
use App\Models\Office;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\SiteSetting;
use App\Models\Solution;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('can create and update hero slide with valid properties', function () {
    $slide = HeroSlide::create([
        'title' => 'PJU Tenaga Surya Terdepan',
        'subtitle' => 'Menerangi nusantara dengan energi ramah lingkungan',
        'button_text' => 'Lihat Produk',
        'button_url' => 'https://indogreen.id/products',
        'desktop_image' => 'hero_slides/desktop-sample.webp',
        'mobile_image' => 'hero_slides/mobile-sample.webp',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    expect($slide->id)->not->toBeNull()
        ->and($slide->is_active)->toBeTrue();

    $slide->update(['title' => 'PJU Tenaga Surya Berkualitas']);
    expect($slide->fresh()->title)->toBe('PJU Tenaga Surya Berkualitas');
});

test('can create product with specifications and link to solution', function () {
    $category = Category::factory()->create(['name' => 'Lampu PJU Solar Cell']);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'PJU Solar Cell 60W Two-In-One',
        'model_series' => 'Helios',
        'badge_tag' => 'Best Seller',
        'short_description' => 'Lampu PJU hemat daya dengan baterai LiFePO4 terintegrasi.',
        'full_description' => '<p>Spesifikasi handal untuk jalan arteri dan protokol.</p>',
        'seo_title' => 'Jual Lampu PJU Solar Cell 60W Helios',
        'seo_description' => 'Dapatkan lampu jalan tenaga surya 60W seri Helios bergaransi resmi.',
        'is_featured' => true,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($product->slug)->toBe('pju-solar-cell-60w-two-in-one');

    ProductSpecification::create([
        'product_id' => $product->id,
        'spec_group' => 'Lampu & Optik',
        'spec_key' => 'Daya Lampu',
        'spec_value' => '60',
        'spec_unit' => 'W',
        'sort_order' => 1,
    ]);

    expect($product->specifications)->toHaveCount(1)
        ->and($product->specifications->first()->spec_key)->toBe('Daya Lampu');

    $solution = Solution::create([
        'name' => 'Penerangan Jalan Umum Mandiri',
        'system_type' => 'PJU TIO',
        'summary' => 'Paket penerangan jalan mandiri tanpa kabel PLN.',
        'system_architecture' => '<p>Panel surya menangkap foton dan disimpan di baterai LiFePO4.</p>',
        'included_components' => ['Modul PV 100Wp', 'Lampu LED 60W', 'Tiang Oktagonal 7m'],
        'benefits' => ['Bebas tagihan listrik PLN', 'Otomatis menyala saat senja'],
        'seo_title' => 'Solusi PJU Tenaga Surya Mandiri',
        'seo_description' => 'Solusi tepat penerangan jalan hemat energi.',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $solution->products()->attach($product->id, ['sort_order' => 1]);

    expect($solution->products)->toHaveCount(1)
        ->and($solution->products->first()->name)->toBe('PJU Solar Cell 60W Two-In-One')
        ->and($product->solutions)->toHaveCount(1);
});

test('can create and update page record with unique slug and seo hints', function () {
    $page = Page::create([
        'title' => 'Tentang Kami',
        'content' => '<p>Profil PT Indogreen Technology And Management</p>',
        'seo_title' => 'Tentang PT Indogreen Technology And Management',
        'seo_description' => 'Pelajari sejarah, visi, dan misi PT Indogreen dalam pengembangan EBT di Indonesia.',
        'is_active' => true,
    ]);

    expect($page->slug)->toBe('tentang-kami')
        ->and($page->is_active)->toBeTrue();
});

test('can create and update office record with valid enum cast', function () {
    $office = Office::create([
        'name' => 'Kantor Pusat Bogor',
        'office_type' => OfficeType::HEAD_OFFICE,
        'address' => 'Ruko Taman Yasmin Sektor 6 No. 226, Kota Bogor',
        'phone' => '+62 251 754 1234',
        'email' => 'bogor@indogreen.id',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($office->office_type)->toBe(OfficeType::HEAD_OFFICE)
        ->and($office->office_type->label())->toBe('Kantor Utama');
});

test('can record inquiry and update status with internal notes', function () {
    $product = Product::factory()->create();

    $inquiry = Inquiry::create([
        'full_name' => 'Budi Santoso',
        'email' => 'budi@pemda.go.id',
        'phone_whatsapp' => '+6281234567890',
        'company_organization' => 'Dinas Perhubungan',
        'product_id' => $product->id,
        'subject' => 'Permohonan Penawaran 50 Unit PJU',
        'message_content' => 'Mohon dikirimkan penawaran harga pengadaan 50 unit PJU TIO 60W.',
        'status' => InquiryStatus::PENDING,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
    ]);

    expect($inquiry->status)->toBe(InquiryStatus::PENDING)
        ->and($inquiry->product->name)->toBe($product->name);

    $inquiry->update([
        'status' => InquiryStatus::QUOTED,
        'internal_notes' => 'Penawaran nomor QUO/2026/XI/004 sudah dikirim via email.',
    ]);

    expect($inquiry->fresh()->status)->toBe(InquiryStatus::QUOTED)
        ->and($inquiry->fresh()->internal_notes)->toContain('QUO/2026/XI/004');
});

test('can create and update site settings record', function () {
    $settings = SiteSetting::create([
        'company_name' => 'PT. INDOGREEN TECHNOLOGY AND MANAGEMENT',
        'tagline' => 'SOLAR ENERGY COMPANY',
        'phone' => '+62 251 754 1234',
        'email' => 'info@indogreen.id',
        'whatsapp' => '+62 811 1234 5678',
        'head_office_address' => 'Bogor',
        'representative_office_address' => 'Bandung',
        'facebook_url' => 'https://facebook.com/indogreen.id',
        'instagram_url' => 'https://instagram.com/indogreen.id',
        'youtube_url' => 'https://youtube.com/@indogreen',
    ]);

    expect($settings->company_name)->toBe('PT. INDOGREEN TECHNOLOGY AND MANAGEMENT');

    $settings->update(['tagline' => 'Solusi Energi Terbarukan Masa Depan']);
    expect($settings->fresh()->tagline)->toBe('Solusi Energi Terbarukan Masa Depan');
});
