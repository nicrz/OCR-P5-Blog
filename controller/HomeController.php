<?php

namespace App\Controller;


class HomeController extends MainController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function home()
    {
        
        $this->twig->display('home.html.twig');
    }



    public function notFound()
    {
        $this->twig->display('not_found.html.twig', ['message' => 'testzer']);
    }


}