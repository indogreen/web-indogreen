<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('roles.manage');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can('roles.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('roles.manage');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->can('roles.manage');
    }

    public function delete(User $user, Role $role): bool
    {
        if (! $user->can('roles.manage')) {
            return false;
        }

        // Peran admin tidak dapat dihapus
        if ($role->name === 'admin') {
            return false;
        }

        return true;
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('roles.manage');
    }
}
