<?php

namespace App\Engine;

use App\Engine\SessionObject;

class Header
{

    public static function set(String $route)
    {
        return header($route);
    }
}