<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\DTO\DepartureResult;
use App\Enums\TrainCategory;
use App\Enums\DepartureStatus;
use PHPUnit\Framework\TestCase;
use App\Services\DutchRailwayService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DutchRailwayServiceTest extends TestCase
{
    public function test_it_can_get_the_departures_by_station(): void
    {
        $dutchRailwayServiceMock = $this->createMock(DutchRailwayService::class);

        $dutchRailwayServiceMock->expects($this->once())
            ->method('getDeparturesByStation')
            ->with('HN')
            ->willReturn(new Collection([
                new DepartureResult(
                    'Amsterdam',
                    'NS1234',
                    DepartureStatus::ON_STATION,
                    '1',
                    TrainCategory::IC,
                    Carbon::now(),
                    Carbon::now(),
                ),
        ]));

        $results = $dutchRailwayServiceMock->getDeparturesByStation('HN');

        $this->assertEquals('Amsterdam', $results->first()->direction);
        $this->assertEquals('NS1234', $results->first()->name);
        $this->assertEquals(DepartureStatus::ON_STATION, $results->first()->status);
        $this->assertEquals(TrainCategory::IC, $results->first()->category);
    }
}
