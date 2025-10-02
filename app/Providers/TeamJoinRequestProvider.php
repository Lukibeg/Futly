<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamJoinRequest;
use App\Models\InviteJoinRequest;
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
            return new TeamJoinRequestService($app->make(Team::class), $app->make(User::class), $app->make(TeamJoinRequest::class), $app->make(InviteJoinRequest::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
