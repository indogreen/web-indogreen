<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('admin role has all 8 permissions', function () {
    $adminRole = Role::findByName('admin', 'web');

    expect($adminRole->permissions)->toHaveCount(8);

    $expectedPermissions = [
        'access-admin',
        'content.manage',
        'settings.manage',
        'inquiries.view',
        'inquiries.update',
        'inquiries.delete',
        'users.manage',
        'roles.manage',
    ];

    foreach ($expectedPermissions as $perm) {
        expect($adminRole->hasPermissionTo($perm))->toBeTrue();
    }
});

test('editor role has only designated permissions', function () {
    $editorRole = Role::findByName('editor', 'web');

    expect($editorRole->permissions)->toHaveCount(4);

    $allowedPermissions = [
        'access-admin',
        'content.manage',
        'inquiries.view',
        'inquiries.update',
    ];

    $deniedPermissions = [
        'settings.manage',
        'inquiries.delete',
        'users.manage',
        'roles.manage',
    ];

    foreach ($allowedPermissions as $perm) {
        expect($editorRole->hasPermissionTo($perm))->toBeTrue();
    }

    foreach ($deniedPermissions as $perm) {
        expect($editorRole->hasPermissionTo($perm))->toBeFalse();
    }
});

test('user assigned role inherits correct permissions', function () {
    $adminUser = User::factory()->create();
    $adminUser->assignRole('admin');

    $editorUser = User::factory()->create();
    $editorUser->assignRole('editor');

    expect($adminUser->can('users.manage'))->toBeTrue()
        ->and($adminUser->can('settings.manage'))->toBeTrue()
        ->and($editorUser->can('content.manage'))->toBeTrue()
        ->and($editorUser->can('users.manage'))->toBeFalse()
        ->and($editorUser->can('inquiries.delete'))->toBeFalse();
});

test('role and permission seeder is idempotent', function () {
    $initialPermissionsCount = Permission::count();
    $initialRolesCount = Role::count();

    // Run seeder again
    $this->seed(RolePermissionSeeder::class);

    expect(Permission::count())->toBe($initialPermissionsCount)
        ->and(Role::count())->toBe($initialRolesCount)
        ->and(Role::findByName('admin')->permissions)->toHaveCount(8)
        ->and(Role::findByName('editor')->permissions)->toHaveCount(4);
});
