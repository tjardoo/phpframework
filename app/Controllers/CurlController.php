<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;

class CurlController
{
    public function index()
    {
        $url = 'https://example.org';

        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($handle);

        // dd(curl_getinfo($handle));

        if ($error = curl_error($handle)) {
            throw new Exception($error);
        }

        dd($result);
    }
}
