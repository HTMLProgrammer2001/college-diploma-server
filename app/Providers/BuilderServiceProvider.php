<?php

namespace App\Providers;

use App\Builders\CategoryBuilder;
use App\Builders\CommissionBuilder;
use App\Builders\DepartmentBuilder;
use App\Builders\EducationBuilder;
use App\Builders\HonorBuilder;
use App\Builders\Interfaces\CategoryBuilderInterface;
use App\Builders\Interfaces\CommissionBuilderInterface;
use App\Builders\Interfaces\DepartmentBuilderInterface;
use App\Builders\Interfaces\EducationBuilderInterface;
use App\Builders\Interfaces\HonorBuilderInterface;
use App\Builders\Interfaces\InternshipBuilderInterface;
use App\Builders\Interfaces\PublicationBuilderInterface;
use App\Builders\Interfaces\QualificationBuilderInterface;
use App\Builders\Interfaces\RankBuilderInterface;
use App\Builders\Interfaces\RebukeBuilderInterface;
use App\Builders\Interfaces\UserBuilderInterface;
use App\Builders\InternshipBuilder;
use App\Builders\PublicationBuilder;
use App\Builders\QualificationBuilder;
use App\Builders\RankBuilder;
use App\Builders\RebukeBuilder;
use App\Builders\UserBuilder;

use Illuminate\Support\ServiceProvider;

class BuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CategoryBuilderInterface::class, CategoryBuilder::class);
        $this->app->singleton(CommissionBuilderInterface::class, CommissionBuilder::class);
        $this->app->singleton(DepartmentBuilderInterface::class, DepartmentBuilder::class);
        $this->app->singleton(EducationBuilderInterface::class, EducationBuilder::class);
        $this->app->singleton(HonorBuilderInterface::class, HonorBuilder::class);
        $this->app->singleton(InternshipBuilderInterface::class, InternshipBuilder::class);
        $this->app->singleton(PublicationBuilderInterface::class, PublicationBuilder::class);
        $this->app->singleton(QualificationBuilderInterface::class, QualificationBuilder::class);
        $this->app->singleton(RankBuilderInterface::class, RankBuilder::class);
        $this->app->singleton(RebukeBuilderInterface::class, RebukeBuilder::class);
        $this->app->singleton(UserBuilderInterface::class, UserBuilder::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
