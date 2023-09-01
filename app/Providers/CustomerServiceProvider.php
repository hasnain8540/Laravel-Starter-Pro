<?php

namespace App\Providers;

use App\Repositories\customer\CustomerCreationInterface;
use App\Repositories\customer\CustomerCreationRepository;
use App\Repositories\customer\CustomerEditInterface;
use App\Repositories\customer\CustomerEditRepository;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomerCreationInterface::class, CustomerCreationRepository::class);
        $this->app->bind(CustomerEditInterface::class, CustomerEditRepository::class);
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
