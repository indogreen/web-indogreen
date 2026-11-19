<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 8 Defined permissions
        $permissions = [
            'access-admin',
            'content.manage',
            'settings.manage',
            'inquiries.view',
            'inquiries.update',
            'inquiries.delete',
            'users.manage',
            'roles.manage',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        // Role: admin (all permissions)
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $adminRole->syncPermissions(Permission::where('guard_name', 'web')->get());

        // Role: editor (access-admin, content.manage, inquiries.view, inquiries.update)
        $editorRole = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'web',
        ]);
        $editorRole->syncPermissions([
            'access-admin',
            'content.manage',
            'inquiries.view',
            'inquiries.update',
        ]);

        // Refresh cache after syncing
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
