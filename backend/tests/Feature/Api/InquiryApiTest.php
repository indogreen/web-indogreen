<?php

use App\Enums\InquiryStatus;
use App\Mail\InquiryReceivedMail;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Solution;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('submitting valid inquiry saves to db, stores ip_hash, and queues notification email', function () {
    Mail::fake();

    $cat = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $cat->id]);
    $solution = Solution::factory()->create();

    $payload = [
        'full_name' => 'Bambang Sudirman',
        'email' => 'bambang@bumn.co.id',
        'phone_whatsapp' => '+6281234567890',
        'company_organization' => 'PT Surya Prima',
        'product_slug' => $product->slug,
        'solution_slug' => $solution->slug,
        'subject' => 'Permintaan Penawaran Tender PLTS',
        'message_content' => 'Mohon dikirimkan proposal penawaran harga 50 unit PLTS.',
        'consent' => true,
        'website_url' => '', // Honeypot empty
    ];

    $response = $this->postJson('/api/v1/inquiries', $payload, ['REMOTE_ADDR' => '203.0.113.195']);

    $response->assertCreated()
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['inquiry_id', 'received_at'],
        ]);

    $inquiryId = $response->json('data.inquiry_id');
    $inquiry = Inquiry::find($inquiryId);

    expect($inquiry)->not->toBeNull()
        ->and($inquiry->full_name)->toBe('Bambang Sudirman')
        ->and($inquiry->product_id)->toBe($product->id)
        ->and($inquiry->solution_id)->toBe($solution->id)
        ->and($inquiry->status)->toBe(InquiryStatus::PENDING)
        ->and($inquiry->consent)->toBeTrue()
        ->and($inquiry->ip_hash)->not->toBe('203.0.113.195') // raw IP is NOT stored
        ->and($inquiry->ip_hash)->toBe(hash('sha256', '203.0.113.195'.config('app.key')));

    Mail::assertQueued(InquiryReceivedMail::class, function ($mail) use ($inquiry) {
        return $mail->inquiry->id === $inquiry->id;
    });
});

test('phone is optional when submitting inquiry', function () {
    Mail::fake();

    $payload = [
        'name' => 'Dewi Sartika',
        'email' => 'dewi@gmail.com',
        'subject' => 'Pertanyaan Teknis',
        'message' => 'Apakah produk Jupiter bergaransi 5 tahun?',
        'consent' => true,
    ];

    $response = $this->postJson('/api/v1/inquiries', $payload);

    $response->assertCreated();
    $inquiry = Inquiry::latest()->first();

    expect($inquiry->full_name)->toBe('Dewi Sartika')
        ->and($inquiry->phone_whatsapp)->toBeNull();
});

test('submitting invalid data returns 422 with validation errors', function () {
    Mail::fake();

    // Empty payload
    $response = $this->postJson('/api/v1/inquiries', []);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'error_code' => 'VALIDATION_ERROR',
        ])
        ->assertJsonValidationErrors(['full_name', 'email', 'subject', 'message_content', 'consent']);

    Mail::assertNothingQueued();
});

test('consent is strictly required to submit inquiry', function () {
    $payload = [
        'full_name' => 'Warga Tanpa Persetujuan',
        'email' => 'user@domain.com',
        'subject' => 'Halo',
        'message_content' => 'Pesan percobaan',
        'consent' => false,
    ];

    $response = $this->postJson('/api/v1/inquiries', $payload);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['consent']);
});

test('message exceeding 2000 characters is rejected', function () {
    $longMessage = str_repeat('a', 2001);

    $payload = [
        'full_name' => 'Spammer',
        'email' => 'spammer@domain.com',
        'subject' => 'Spam panjang',
        'message_content' => $longMessage,
        'consent' => true,
    ];

    $response = $this->postJson('/api/v1/inquiries', $payload);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['message_content']);
});

test('honeypot traps bots silently without saving to database or sending mail', function () {
    Mail::fake();

    $payload = [
        'full_name' => 'Bot Spammer',
        'email' => 'bot@spammer.com',
        'subject' => 'Buy Cheap Stuff',
        'message_content' => 'Spam content here',
        'consent' => true,
        'website_url' => 'https://evil-spammer-website.com', // Bot fell into honeypot trap!
    ];

    $response = $this->postJson('/api/v1/inquiries', $payload);

    // Returns fake 201 success so bot thinks it succeeded
    $response->assertCreated();

    // Verify nothing saved to database
    expect(Inquiry::where('email', 'bot@spammer.com')->exists())->toBeFalse();

    Mail::assertNothingQueued();
});

test('inquiry endpoint enforces rate limit of 5 requests per minute per ip', function () {
    $payload = [
        'full_name' => 'Rate Limit Tester',
        'email' => 'tester@test.com',
        'subject' => 'Tes',
        'message_content' => 'Tes pesan berulang',
        'consent' => true,
    ];

    for ($i = 1; $i <= 5; $i++) {
        $res = $this->postJson('/api/v1/inquiries', $payload, ['REMOTE_ADDR' => '192.0.2.10']);
        $res->assertCreated();
    }

    // 6th request within the same minute from the same IP must be throttled
    $blocked = $this->postJson('/api/v1/inquiries', $payload, ['REMOTE_ADDR' => '192.0.2.10']);
    $blocked->assertStatus(429)
        ->assertJson([
            'success' => false,
            'error_code' => 'RATE_LIMIT_EXCEEDED',
        ]);
});
