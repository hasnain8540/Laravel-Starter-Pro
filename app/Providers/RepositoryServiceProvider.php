<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\role\RoleInterface;
use App\Repositories\user\UserInterface;
use App\Repositories\role\RoleRepository;
use App\Repositories\user\UserRepository;
use App\Repositories\module\ModuleInterface;
use App\Repositories\module\ModuleRespository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\permission\PermissionInterface;
use App\Repositories\permission\PermissionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);

        $this->app->bind(ModuleInterface::class, ModuleRespository::class);
        $this->app->bind(PermissionInterface::class, PermissionRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
