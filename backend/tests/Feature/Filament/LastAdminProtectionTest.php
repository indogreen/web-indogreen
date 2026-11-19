<?php

use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('last admin user cannot be deleted', function () {
    $policy = new UserPolicy;

    $onlyAdmin = User::factory()->create();
    $onlyAdmin->assignRole('admin');

    expect(User::role('admin')->count())->toBe(1);

    // Attempting to delete the only admin fails
    expect($policy->delete($onlyAdmin, $onlyAdmin))->toBeFalse();
});

test('admin can be deleted if another admin exists', function () {
    $policy = new UserPolicy;

    $admin1 = User::factory()->create();
    $admin1->assignRole('admin');

    $admin2 = User::factory()->create();
    $admin2->assignRole('admin');

    expect(User::role('admin')->count())->toBe(2);

    // Deleting one admin is permitted because another admin exists
    expect($policy->delete($admin1, $admin2))->toBeTrue();
});

test('admin role itself cannot be deleted', function () {
    $policy = new RolePolicy;

    $adminUser = User::factory()->create();
    $adminUser->assignRole('admin');

    $adminRole = Role::findByName('admin');

    expect($policy->delete($adminUser, $adminRole))->toBeFalse();
});

test('custom non-admin role can be deleted by user with roles manage permission', function () {
    $policy = new RolePolicy;

    $adminUser = User::factory()->create();
    $adminUser->assignRole('admin');

    $customRole = Role::create(['name' => 'temporary_role']);

    expect($policy->delete($adminUser, $customRole))->toBeTrue();
});
