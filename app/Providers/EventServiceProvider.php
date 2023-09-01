<?php

namespace App\Providers;

use App\Models\Inventory;
use App\Models\PartBin;
// use App\Models\Upc;
// use App\Observers\InventoryObserver;
use App\Observers\PartBinObserver;
// use App\Observers\UpcObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UserLoginAt',
        ],
    ];

    // protected $observers = [
    //     Upc::class => [UpcObserver::class],
    // ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Upc::observe(UpcObserver::class);
        // Inventory::observe(InventoryObserver::class);
        // PartBin::observe(PartBinObserver::class);
        //
    }
}
