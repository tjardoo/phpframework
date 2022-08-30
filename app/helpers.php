<?php

use App\Routing\Redirect;

if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

if (!function_exists('redirect')) {
    function redirect()
    {
        $args = func_get_args();

        Redirect::to(...$args);
    }
}
