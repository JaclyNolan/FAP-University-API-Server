<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function(User $user) {
            return $user->getRoleName() === "Admin"
            ? Response::allow()
            : Response::deny("You must be an administrator");
        });

        Gate::define('isAdminOrStaff', function(User $user) {
            return ($user->getRoleName() === "Admin") || ($user->getRoleName() === "Staff")
            ? Response::allow()
            : Response::deny("You must be an administrator or a staff");
        });

        Gate::define('isInstructor', function(User $user){
            return ($user->getRoleName() === "Instructor")
            ? Response::allow()
            : Response::deny("You must be an instructor");
        });

        Gate::define('isStudent', function(User $user){
            return ($user->getRoleName() === "Student")
            ? Response::allow()
            : Response::deny("You must be a student");
        });
    }
}
