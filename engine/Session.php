<?php

namespace App\Engine;

use App\Engine\SessionObject;

class Session
{

    public function start()
    {
        session_start();
    }

    public static function set($key, $val)
    {

        $session = new SessionObject();

        $session->vars[$key] = $val;
    }

    public function get($key)
    {

        $session = new SessionObject();


        if (isset($session->vars[$key])) {
            return $session->vars[$key];
        }
    }

    public static function destroy()
    {
        return session_destroy();
    }
}