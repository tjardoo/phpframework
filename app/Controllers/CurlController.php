<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\DutchRailwayService;

class CurlController
{
    public function __construct(
        private DutchRailwayService $dutchRailwayService
    ) {
    }

    public function index()
    {
        $station = 'HN'; // Hoorn

        $result = $this->dutchRailwayService->getDeparturesByStation($station);

        dd($result);
    }
}
