<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class RouteMethodNotSupportedException extends Exception
{
    protected $message = 'Route method not supported.';
}
