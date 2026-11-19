<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function view(User $user, Page $page): bool
    {
        return $user->can('content.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function update(User $user, Page $page): bool
    {
        return $user->can('content.manage');
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->can('content.manage');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('content.manage');
    }
}
