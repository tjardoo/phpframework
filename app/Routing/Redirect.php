<?php

namespace App\Routing;

class Redirect
{
    public static function to(string $uri, int $statusCode = 301)
    {
        header("Location: {$uri}", true, $statusCode);

        die();
    }
}
