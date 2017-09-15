<?php

namespace App\Providers;

use App\Repositories\DoctrineUnitOfWork;
use App\Repositories\UnitOfWorkInterface;
use App\ViewModels\RequestDataSource;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use SolveX\ViewModel\DataSourceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register custom enum types.

        // Use Carbon instead of PHP's date in Doctrine entities.
        Type::overrideType('datetime', DoctrineCarbonType::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UnitOfWorkInterface::class, DoctrineUnitOfWork::class);
        $this->app->bind(DataSourceInterface::class, RequestDataSource::class);
    }
}
