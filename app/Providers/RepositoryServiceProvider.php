<?php

namespace App\Providers;

use App\Repositories\EducationRepository;
use App\Repositories\HonorRepository;
use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use App\Repositories\Interfaces\PublicationRepositoryInterface;
use App\Repositories\Interfaces\RebukeRepositoryInterface;
use App\Repositories\PublicationRepository;
use App\Repositories\RebukeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(PublicationRepositoryInterface::class, PublicationRepository::class);
        $this->app->singleton(EducationRepositoryInterface::class, EducationRepository::class);
        $this->app->singleton(HonorRepositoryInterface::class, HonorRepository::class);
        $this->app->singleton(RebukeRepositoryInterface::class, RebukeRepository::class);
    }
}
