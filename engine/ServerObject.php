<?php

namespace App\Engine;

class ServerObject
{
    public $vars;

    public function __construct() {
        $this->vars = &$_SERVER; //this will still trigger a phpmd warning
    }
}