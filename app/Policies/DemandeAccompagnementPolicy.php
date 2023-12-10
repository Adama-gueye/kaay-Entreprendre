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
        return true;
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
    public function store (User $user):bool
    {
          return $user->role === 'novice' ;
        // return $user->role ===  'novice'
        // ? Response::allow()
        // : Response::deny('Vous n\'etes pas autorise a faire cette action.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        {
            return $user->role ===  'admin'
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorise a faire cette action.');
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        {
            return $user->role ===  'admin'
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorise a faire cette action.');
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DemandeAccompagnement $demandeAccompagnement): bool
    {
        return true;
    }
}
