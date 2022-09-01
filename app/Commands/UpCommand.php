<?php

namespace App\Commands;

use App\Commands\Command;

class UpCommand extends Command
{
    protected string $signature = 'up';

    public function handle(): int
    {
        if ($this->app->isDownForMaintenance() == false) {
            echo 'Application is already up.';

            return Command::SUCCESS;
        }

        if (is_file(path('storage'). '/down')) {
            unlink(path('storage'). '/down');
        }

        echo 'Application is now live.';

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('This command puts the application out of maintenance mode.');
    }
}
