<?php

declare(strict_types=1);

namespace App\Controllers;

class InvokeController
{
    public function __invoke()
    {
        dd('Invokable Controller');
    }
}
