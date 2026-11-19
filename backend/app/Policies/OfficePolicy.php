<?php

namespace App\Policies;

use App\Models\Office;
use App\Models\User;

class OfficePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function view(User $user, Office $office): bool
    {
        return $user->can('content.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function update(User $user, Office $office): bool
    {
        return $user->can('content.manage');
    }

    public function delete(User $user, Office $office): bool
    {
        return $user->can('content.manage');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('content.manage');
    }
}
