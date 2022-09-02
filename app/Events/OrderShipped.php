<?php

namespace App\Events;

use App\Traits\Dispatchable;

class OrderShipped
{
    use Dispatchable;

    public $orderId;

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }
}
