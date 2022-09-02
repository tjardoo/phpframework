<?php

namespace App\Events;

use App\Traits\Dispatchable;

class OrderReturned
{
    use Dispatchable;

    public $orderId;

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }
}
