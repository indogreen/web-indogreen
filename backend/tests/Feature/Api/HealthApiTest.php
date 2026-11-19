<?php

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('health endpoint reports UP status with database and storage services', function () {
    $response = $this->getJson('/api/v1/health');

    $response->assertOk()
        ->assertJson([
            'success' => true,
            'status' => 'UP',
            'services' => [
                'database' => 'CONNECTED',
                'storage' => 'WRITABLE',
            ],
        ]);
});
