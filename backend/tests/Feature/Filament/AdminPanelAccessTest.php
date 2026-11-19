<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('guest is redirected to admin login page', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/admin/login');
});

test('admin user can access admin panel', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertSuccessful();
});

test('editor user can access admin panel', function () {
    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $response = $this->actingAs($editor)->get('/admin');

    $response->assertSuccessful();
});

test('user without access-admin permission is forbidden from admin panel', function () {
    $regularUser = User::factory()->create();

    $response = $this->actingAs($regularUser)->get('/admin');

    $response->assertForbidden();
});

test('user with custom role lacking access-admin is forbidden', function () {
    $customRole = Role::create(['name' => 'viewer']);
    $user = User::factory()->create();
    $user->assignRole($customRole);

    $response = $this->actingAs($user)->get('/admin');

    $response->assertForbidden();
});
