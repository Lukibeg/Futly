<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(UserService::class);
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
