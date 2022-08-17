<?php

namespace App\Enums;

enum DepartureStatus: string
{
    case INCOMING = 'INCOMING';
    case ON_STATION = 'ON_STATION';

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            DepartureStatus::INCOMING => 'Incoming',
            DepartureStatus::ON_STATION => 'On station',
        };
    }
}
