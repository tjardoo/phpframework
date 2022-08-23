<?php

declare(strict_types=1);

namespace App\Controllers;

use Monolog\Logger;

class LogController
{
    public function __construct(
        protected Logger $logger
    ) {
    }

    public function index()
    {
        $this->logger->info('This INFO line will be added to the log.');
        $this->logger->debug('This DEBUG line will be added to the log.', ['foo' => 'bar']);

        dd('log completed');
    }
}
