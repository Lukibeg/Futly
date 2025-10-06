<?php

namespace App\Providers;

use App\Repositories\TeamEloquentRepository;
use App\Repositories\TeamRepositoryInterface;
use App\Services\TeamService;
use Illuminate\Support\ServiceProvider;

class TeamServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TeamRepositoryInterface::class,
            TeamEloquentRepository::class
        );
        $this->app->bind(TeamService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
