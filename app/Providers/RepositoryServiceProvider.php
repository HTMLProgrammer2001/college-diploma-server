<?php

namespace App\Providers;

use App\Repositories\DepartmentRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\EducationRepositoryInterface;
use App\Repositories\Interfaces\HonorRepositoryInterface;
use App\Repositories\Interfaces\InternshipRepositoryInterface;
use App\Repositories\Interfaces\PublicationRepositoryInterface;
use App\Repositories\Interfaces\QualificationRepositoryInterface;
use App\Repositories\Interfaces\RebukeRepositoryInterface;

use App\Repositories\CategoryRepository;
use App\Repositories\EducationRepository;
use App\Repositories\HonorRepository;
use App\Repositories\InternshipRepository;
use App\Repositories\PublicationRepository;
use App\Repositories\QualificationRepository;
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
        $this->app->singleton(QualificationRepositoryInterface::class, QualificationRepository::class);
        $this->app->singleton(InternshipRepositoryInterface::class, InternshipRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(DepartmentRepositoryInterface::class, DepartmentRepository::class);
    }
}
