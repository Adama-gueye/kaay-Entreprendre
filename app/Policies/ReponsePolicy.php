<?php

namespace App\Policies;

use App\Models\Reponse;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReponsePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reponse $reponse): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'experimente' || 'novice';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function show(User $user, Reponse $reponse): bool
    {

        return true;
    }

    public function update(User $user, Reponse $reponse): bool
    {
        return  $user->id === $reponse->user_id;
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Reponse $reponse): bool
    {
        return $user->role === 'admin' || $user->id === $reponse->user_id;
    }

}
