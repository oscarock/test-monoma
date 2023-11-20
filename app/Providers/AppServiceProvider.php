<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AspirantRepositoryInterface;
use App\Repositories\EloquentAspirantRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AspirantRepositoryInterface::class, EloquentAspirantRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
