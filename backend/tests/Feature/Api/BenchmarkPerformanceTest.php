<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('list endpoints respond within target p95 latency under 200ms', function () {
    $endpoints = [
        '/api/v1/home',
        '/api/v1/products',
        '/api/v1/product-categories',
        '/api/v1/solutions',
        '/api/v1/settings',
        '/api/v1/sitemap-entries',
    ];

    $latencies = [];

    // Warm up cache first
    foreach ($endpoints as $url) {
        $this->getJson($url)->assertOk();
    }

    // Benchmark 20 iterations across list endpoints
    for ($i = 0; $i < 20; $i++) {
        foreach ($endpoints as $url) {
            $start = microtime(true);
            $res = $this->getJson($url);
            $durationMs = (microtime(true) - $start) * 1000;

            $res->assertOk();
            $latencies[$url][] = $durationMs;
        }
    }

    // Calculate percentiles
    foreach ($latencies as $url => $times) {
        sort($times);
        $count = count($times);
        $p50Index = (int) floor($count * 0.50);
        $p90Index = (int) floor($count * 0.90);
        $p95Index = (int) floor($count * 0.95);

        $p50 = round($times[$p50Index], 2);
        $p90 = round($times[$p90Index], 2);
        $p95 = round($times[$p95Index], 2);
        $max = round(max($times), 2);

        // Target p95 di bawah 200 ms lokal
        expect($p95)->toBeLessThan(200.0);
    }
});
