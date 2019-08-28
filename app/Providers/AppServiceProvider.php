<?php

namespace App\Providers;

use App\Repositories\Contracts\DiaryInterface;
use App\Repositories\Contracts\UserInterface;
use App\Repositories\Eloquent\DiaryRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\Services\Contracts\DiaryServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Services\DiaryServices;
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
        $this->app->singleton(DiaryInterface::class, DiaryRepositoryEloquent::class);
        $this->app->singleton(UserServiceInterface::class, UserServices::class);
        $this->app->singleton(DiaryServiceInterface::class, DiaryServices::class);
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
