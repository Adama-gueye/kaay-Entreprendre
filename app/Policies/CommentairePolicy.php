<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Commentaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Traits\ReturnJsonResponseTrait;



class CommentairePolicy
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
    public function view(User $user, Commentaire $commentaire): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role !== 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Commentaire $commentaire): bool
    {
        return $commentaire->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Commentaire $commentaire) : bool
    {
        return $commentaire->user_id === $user->id || $user->role === 'admin';
    }


}
