<?php

namespace App\Providers;

use Doctrine\DBAL\Types\Type;
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
        //
    }
}
