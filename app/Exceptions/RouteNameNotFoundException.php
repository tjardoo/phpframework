<?php

namespace App\Exceptions;

use Exception;

class RouteNameNotFoundException extends Exception
{
    protected $message = 'Route name not found.';
}
