<?php

namespace App\Commands;

use App\App;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Command extends SymfonyCommand
{
    protected App $app;

    public function __construct(App $app)
    {
        parent::__construct($this->signature);

        $this->app = $app;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $args = func_get_args();

        if (method_exists($this, 'handle')) {
            return call_user_func([$this, 'handle'], ...$args);
        }

        throw new Exception('Method handle not found in command: ' . get_class($this));
    }
}
