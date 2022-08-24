<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config;
use App\Facades\MyClassFacade;
use Monolog\Logger;
use App\Models\User;
use Twig\Environment as Twig;

class HomeController
{
    public function __construct(
        private Twig $twig,
        private Logger $logger,
        private Config $config,
    ) {
    }

    public function index(): string
    {
        $user = User::find(1);

        $this->logger->debug('This is a test with config variable: ' . $this->config->db['driver']);

        return $this->twig->render('welcome.twig', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }

    public function placeholderTester(string $foo): string
    {
        dd('placeholderTester: ' . $foo);
    }
}
