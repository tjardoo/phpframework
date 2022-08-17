<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Twig\Environment as Twig;

class HomeController
{
    public function __construct(
        private Twig $twig,
    ) {
    }

    public function index(): string
    {
        $user = User::find(1);

        return $this->twig->render('welcome.twig', [
            'foo' => 'bar',
            'user' => $user,
        ]);
    }
}
