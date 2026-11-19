<?php

namespace App\Policies;

use App\Models\Solution;
use App\Models\User;

class SolutionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function view(User $user, Solution $solution): bool
    {
        return $user->can('content.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function update(User $user, Solution $solution): bool
    {
        return $user->can('content.manage');
    }

    public function delete(User $user, Solution $solution): bool
    {
        return $user->can('content.manage');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('content.manage');
    }
}
