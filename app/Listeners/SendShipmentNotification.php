<?php

namespace App\Listeners;

use App\Events\OrderShipped;

class SendShipmentNotification
{
    public function handle(OrderShipped $event): void
    {
        dump('SendShipmentNotification triggered for order: ' . $event->orderId);
    }
}
