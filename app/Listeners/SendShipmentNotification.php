<?php

namespace App\Listeners;

use App\Events\OrderReturned;
use App\Events\OrderShipped;

class SendShipmentNotification
{
    public function handle(OrderShipped|OrderReturned $event): void
    {
        dump('SendShipmentNotification triggered for order: ' . $event->orderId);
    }
}
