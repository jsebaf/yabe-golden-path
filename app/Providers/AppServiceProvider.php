<?php

namespace App\Providers;

use App\Contracts\AvailabilityDataSource;
use App\Services\EloquentDataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AvailabilityDataSource::class, EloquentDataService::class);
    }

    public function boot(): void
    {
        //
    }
}
