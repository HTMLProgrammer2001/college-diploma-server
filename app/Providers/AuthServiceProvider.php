<?php

namespace App\Providers;

use App\Models\Commission;
use App\Models\Department;
use App\Models\Education;
use App\Models\Honor;
use App\Models\InternCategory;
use App\Models\Internship;
use App\Models\Publication;
use App\Models\Qualification;
use App\Models\Rank;
use App\Models\Rebuke;
use App\Models\User;

use App\Policies\CommissionPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EducationPolicy;
use App\Policies\HonorPolicy;
use App\Policies\InternCategoryPolicy;
use App\Policies\InternshipPolicy;
use App\Policies\PublicationPolicy;
use App\Policies\QualificationPolicy;
use App\Policies\RankPolicy;
use App\Policies\RebukePolicy;
use App\Policies\UserPolicy;

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
        Commission::class => CommissionPolicy::class,
        Department::class => DepartmentPolicy::class,
        InternCategory::class => InternCategoryPolicy::class,
        Education::class => EducationPolicy::class,
        Honor::class => HonorPolicy::class,
        Internship::class => InternshipPolicy::class,
        Publication::class => PublicationPolicy::class,
        Rank::class => RankPolicy::class,
        Rebuke::class => RebukePolicy::class,
        Qualification::class => QualificationPolicy::class,
        User::class => UserPolicy::class
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
