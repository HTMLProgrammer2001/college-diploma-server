<?php

namespace App\Providers;

use App\Repositories\Interfaces\PublicationRepositoryInterface;
use App\Repositories\PublicationRepository;
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
    }
}
