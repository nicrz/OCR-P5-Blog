<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Engine\Session;


class MainController{

    protected $twig;

    // Récupère l'environnement de templating TWIG et ajoute la variable $_SESSION en tant que variable globale
    // pour pouvoir l'utiliser dans chaque template TWIG

    public function __construct(){

            $loader = new FilesystemLoader('view');

        $this->twig = new Environment($loader, [
            //'cache' => __DIR__ . '/tmp',
            'debug' => true
        ]);
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
        $basePath = "http://localhost/OCR-P5-Blog";
        $this->twig->addGlobal('basePath', $basePath);
    }

}