<?php

namespace App\Policies;

use App\Models\Ressource;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RessourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ressource $ressource): bool
    {
        return true;
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
    public function update(User $user, Ressource $ressource): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ressource $ressource): bool
    {
        return $user->role === 'admin';
    }

   
}
