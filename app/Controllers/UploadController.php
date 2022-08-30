<?php

declare(strict_types=1);

namespace App\Controllers;

use Twig\Environment as Twig;

class UploadController
{
    public function __construct(
        private Twig $twig,
    ) {
    }

    public function show(): string
    {
        return $this->twig->render('upload.html.twig');
    }

    public function store(): void
    {
        $filePath = STORAGE_PATH . '/uploads/' . $_FILES['avatar']['name'];

        move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath);

        dd(pathinfo($filePath));
    }
}
