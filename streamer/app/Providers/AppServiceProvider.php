<?php

namespace App\Providers;

use App\Repositories\DoctrineUnitOfWork;
use App\Repositories\UnitOfWorkInterface;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

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
        // http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/configuration.html
        $paths = [base_path('app/Entities')];
        $isDevMode = false;

        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'dbname'   => env('DB_DATABASE'),
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);

        $this->app->bind(UnitOfWorkInterface::class, function () use ($entityManager) {
            return new DoctrineUnitOfWork($entityManager);
        });
    }
}
