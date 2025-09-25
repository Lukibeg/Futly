<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamJoinRequest;
use App\Services\TeamJoinRequestService;
use Illuminate\Support\ServiceProvider;

class TeamJoinRequestProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TeamJoinRequestService::class, function ($app) {
            return new TeamJoinRequestService($app->make(Team::class), $app->make(User::class), $app->make(TeamJoinRequest::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(TeamJoinRequestService::class, TeamJoinRequestService::class);
    }
}
