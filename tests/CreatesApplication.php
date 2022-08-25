<?php

namespace Tests;

trait CreatesApplication
{
    protected function createsApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->boot();

        return $app;
    }
}
