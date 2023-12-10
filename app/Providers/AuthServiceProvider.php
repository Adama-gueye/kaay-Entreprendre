<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

// use App\Models\DemandeAccompagnement;
use App\Models\User;
use App\Policies\GuidePolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Commentaire::class => CommentairePolicy::class,
        DemandeAccompagnement::class => DemandeAccompagnementPolicy::class,
        Guide::class => GuidePolicy::class,
    ];

   

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        
        Gate::define('isAdmin', function(User $user )  {
           
            return ($user->role !== 'admin')
            ? Response::allow()
            : Response::deny('Vous n\'avez pas l\'autorisation requise d\'exécuter cette action.');
        } );
    }
}
