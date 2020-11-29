<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        //define gates for each user group
        Gate::define('user', function ($user){
            return $user->role <= \Constants::$roles['user'];
        });

        Gate::define('moderator', function ($user){
            return $user->role <= \Constants::$roles['moderator'];
        });

        Gate::define('viewer', function ($user){
            return $user->role <= \Constants::$roles['viewer'];
        });

        Gate::define('admin', function ($user){
            return $user->role <= \Constants::$roles['admin'];
        });
    }
}
