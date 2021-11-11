<?php

namespace App\Providers;

use App\Services\ApiResponseCacheService;
use App\Services\Interfaces\ApiResponseServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiResponseServiceInterface::class,ApiResponseCacheService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
