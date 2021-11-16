<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


class MainController{

    protected $twig;

    public function __construct(){

            $loader = new FilesystemLoader('view');

        $this->twig = new Environment($loader, [
            //'cache' => __DIR__ . '/tmp',
            'debug' => true
        ]);

        $this->twig->addExtension(new DebugExtension());
    }

}