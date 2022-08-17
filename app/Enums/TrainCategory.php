<?php

namespace App\Enums;

enum TrainCategory: string
{
    case IC = 'IC';
    case SPR = 'SPR';

    public function label(): string
    {
        return static::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            TrainCategory::IC => 'Intercity',
            TrainCategory::SPR => 'Sprinter',
        };
    }
}
