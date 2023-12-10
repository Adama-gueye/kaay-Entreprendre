<?php

namespace App\Policies;

use App\Models\Guide;
use App\Models\User;


class GuidePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Guide $guide): bool
    {
        return $user->role === 'admin' || $user->role === 'novice' ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Guide $guide): bool
    {
        return $user->role === 'admin' ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Guide $guide): bool
    {
        return $user->role === 'admin';
    }

}
