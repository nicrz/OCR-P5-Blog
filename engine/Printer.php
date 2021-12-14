<?php

namespace App\Engine;

use App\Engine\SessionObject;

class Printer
{

    public static function set(String $text)
    {
        return print_r($text);
    }
}