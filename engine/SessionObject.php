<?php

namespace App\Engine;

class SessionObject
{
    public $vars;

    public function __construct() {
        $this->vars = &$_SESSION; //this will still trigger a phpmd warning
    }
}
