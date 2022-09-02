<?php

namespace App\Providers;

use App\Event;
use App\Events\OrderReturned;
use App\Events\OrderShipped;
use App\Providers\ServiceProvider;
use App\Listeners\SendShipmentNotification;

class EventServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::subscribe(
            [OrderShipped::class, OrderReturned::class],
            SendShipmentNotification::class
        );
    }
}
