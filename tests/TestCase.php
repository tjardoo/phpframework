<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // protected $preserveGlobalState = false;

    // protected $runTestInSeparateProcess = true;

    protected $app;

    protected function setUp(): void
    {
        $this->app = $this->createsApplication();
    }
}
