<?php

namespace App\Commands;

use App\Config;

class ServeCommand extends Command
{
    protected string $signature = 'serve';

    public function handle(): int
    {
        $url = Config::get('url');

        exec("php -S {$url} -t public");

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('Starts the PHP web server.');
    }
}
