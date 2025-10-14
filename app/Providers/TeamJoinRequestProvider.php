<?php

namespace App\Providers;

use App\Repositories\Interface\TeamInviteRepositoryInterface;
use App\Repositories\TeamInviteEloquentRepository;
use App\Services\TeamJoinRequestService;
use Illuminate\Support\ServiceProvider;

class TeamJoinRequestProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TeamInviteRepositoryInterface::class,
            TeamInviteEloquentRepository::class
        );
        $this->app->bind(TeamJoinRequestService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
