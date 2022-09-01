<?php

namespace App\Commands;

use App\Commands\Command;

class DownCommand extends Command
{
    protected string $signature = 'down';

    public function handle(): int
    {
        if ($this->app->isDownForMaintenance()) {
            echo 'Application is already down.';

            return Command::SUCCESS;
        }

        file_put_contents(
            path('storage') . '/down',
            'N/A'
        );

        echo 'Application is now in maintenance mode.';

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('This command puts the application in maintenance mode.');
    }
}
