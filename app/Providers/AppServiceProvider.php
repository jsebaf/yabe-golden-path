<?php

namespace App\Providers;

use App\Contracts\AvailabilityDataSource;
use App\Services\MockDataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MockDataService::class);
        $this->app->singleton(AvailabilityDataSource::class, fn ($app) => $app->make(MockDataService::class));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
