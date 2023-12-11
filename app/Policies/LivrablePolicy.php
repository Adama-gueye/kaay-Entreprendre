<?php

namespace App\Policies;

use App\Models\Livrable;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LivrablePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role ===  'admin' ; 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Livrable $livrable): bool
    {
        return $user->role === 'admin' || $livrable->user_id = $user->id ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        return $user->role === 'novice';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Livrable $livrable): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Livrable $livrable): bool
    {
        return $user->role === 'admin' || $user->id === $livrable->user_id;
    }
   
}
