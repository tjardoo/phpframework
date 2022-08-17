<?php

namespace App\DTO;

use Carbon\Carbon;
use App\Enums\TrainCategory;
use App\Enums\DepartureStatus;

class DepartureResult
{
    public function __construct(
        public string $direction,
        public string $name,
        public DepartureStatus $status,
        public string $track,
        public TrainCategory $category,
        public Carbon $plannedAt,
        public Carbon $actualAt,
    ) {
    }
}
