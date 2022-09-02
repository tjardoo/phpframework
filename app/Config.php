<?php

declare(strict_types=1);

namespace App;

class Config
{
    protected static array $items = [];

    public function __construct(array $items = [])
    {
        self::$items = $items;
    }

    public static function get($keys, $default = null): mixed
    {
        $items = self::$items;

        if ($keys == null) {
            return $items;
        }

        $filteredItems = $items;

        foreach (explode('.', $keys) as $key) {
            if (array_key_exists($key, $filteredItems)) {
                $filteredItems = $filteredItems[$key];
            } else {
                return $default;
            }
        }

        return $filteredItems;
    }

    public static function all(): array
    {
        return self::$items;
    }
}
