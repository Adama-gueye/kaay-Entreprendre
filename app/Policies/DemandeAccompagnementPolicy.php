<?php

namespace App\Policies;

use App\Models\DemandeAccompagnement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DemandeAccompagnementPolicy
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
    public function view(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        return true;

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
    public function update(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        return $user->role ===  'admin' || $demandeAccompagnement->user_id === $user->id;
    }

}
