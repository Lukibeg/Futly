<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Repositories\EloquentRepository;
use App\Repositories\RepositoryInterface;
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
            RepositoryInterface::class,
            EloquentRepository::class
        );
        $this->app->bind(TeamService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
