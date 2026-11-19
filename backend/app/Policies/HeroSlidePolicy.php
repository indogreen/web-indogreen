<?php

namespace App\Policies;

use App\Models\HeroSlide;
use App\Models\User;

class HeroSlidePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function view(User $user, HeroSlide $heroSlide): bool
    {
        return $user->can('content.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('content.manage');
    }

    public function update(User $user, HeroSlide $heroSlide): bool
    {
        return $user->can('content.manage');
    }

    public function delete(User $user, HeroSlide $heroSlide): bool
    {
        return $user->can('content.manage');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('content.manage');
    }
}
