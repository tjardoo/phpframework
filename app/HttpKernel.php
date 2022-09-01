<?php

namespace App;

use App\App;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HttpKernel
{
    protected App $app;

    protected Console $console;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function registerCommands()
    {
        $this->console->add(new \App\Commands\DownCommand($this->app));
        $this->console->add(new \App\Commands\UpCommand($this->app));
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $this->app->boot();

        $this->console = new Console();

        $this->registerCommands();

        $this->console->run();
    }
}
