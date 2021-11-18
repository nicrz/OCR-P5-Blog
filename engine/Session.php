<?php

namespace App\Engine;

class Session
{

    public function start()
    {
        session_start();
    }

    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function destroy()
    {
        return session_destroy();
    }
}