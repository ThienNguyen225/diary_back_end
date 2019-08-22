<?php

namespace App\Providers;

use App\Repositories\Contracts\UserInterface;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Services\UserServices;
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
        $this->app->singleton(UserInterface::class, UserRepositoryEloquent::class);
        $this->app->singleton(UserServiceInterface::class, UserServices::class);
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
