<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Services\TeamService;

use Illuminate\Support\ServiceProvider;

class TeamServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TeamService::class, function ($app) {
            return new TeamService($app->make(Team::class), $app->make(User::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(TeamService::class, TeamService::class);
    }
}
