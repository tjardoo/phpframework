<?php

namespace App;

class Event
{
    protected static array $observers = [];

    public static function subscribe(string|array $events, string $listener)
    {
        foreach ((array) $events as $event) {
            self::$observers[$event][] = $listener;
        }
    }

    public static function getEvents(): array
    {
        return self::$observers;
    }

    public static function getListeners(string $event): array
    {
        return self::$observers[$event] ?? [];
    }
}
