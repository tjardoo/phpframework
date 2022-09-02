<?php

namespace App\Traits;

use App\EventDispatcher;

trait Dispatchable
{
    public static function dispatch()
    {
        $event = new static(...func_get_args());

        return (new EventDispatcher())->dispatch($event);
    }
}
