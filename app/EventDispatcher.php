<?php

namespace App;

class EventDispatcher
{
    public function dispatch($event)
    {
        [$class, $args] = $this->parseEventAndProperties($event);

        foreach (Event::getListeners($class) as $listener) {
            if (class_exists($listener)) {
                if (method_exists($listener, 'handle')) {
                    $newListener = new $listener();
                    call_user_func_array([$newListener, 'handle'], [$event]);
                }
            }
        }
    }

    private function parseEventAndProperties($event)
    {
        $class = get_class($event);
        $properties = get_object_vars($event);

        return [$class, $properties];
    }
}
